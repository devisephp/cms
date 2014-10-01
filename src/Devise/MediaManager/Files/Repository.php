<?php namespace Devise\MediaManager\Files;

use Config, Request, URL, File;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;

class Repository
{
    protected $Filesystem, $config, $guesser, $input;

    public function __construct(Filesystem $Filesystem)
    {
        $this->Filesystem = $Filesystem;
        $this->config = Config::get('devise::media-manager');
        $this->guesser = MimeTypeGuesser::getInstance();
        $this->basepath = public_path().'/'.$this->config['root-dir'] . '/';
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function compileIndexData($results, $input = null)
    {
        $data = [];
        $this->input = $input;
        if($results['capable'])
        {
            $currentDirectory = $this->getCurrentDirectory($input);
            $data['crumbs'] = $this->buildCrumbs( $input );
            $data['categories'] = $this->buildCategories( $currentDirectory, $input );
            $data['media-items'] = $this->buildMediaItems( $currentDirectory, $input );
            $data['searched-items'] = $this->buildSearchedItems( $currentDirectory, array_get($input, 'search'));
        }

        return $data;
    }

    private function getCurrentDirectory($input)
    {
        if(!isset($input['category'])){
            return public_path().'/'.$this->config['root-dir'];
        } else {
            $dirPath = implode('/', explode('.', $input['category']));
            return public_path().'/'.$this->config['root-dir'] . '/' . $dirPath;
        }
    }

    private function buildCrumbs($input)
    {
        $crumbs = array(
            array(
                'name' => 'Main',
                'url' => Request::url() .'?'. http_build_query(array_except($input, 'category'))
            )
        );

        if(isset($input['category'])){
            $parts = explode('.', $input['category']);
            $crumbDotPath = '';
            foreach ($parts as $part) {
                $crumbDotPath .= ($crumbDotPath != '') ? '.' . $part : $part;
                $input['category'] = $crumbDotPath;
                $crumbs[] = array(
                    'name' => $part,
                    'url' => Request::url() .'?'. http_build_query($input)
                );
            }

        }

        return $crumbs;
    }

    private function buildCategories($dir, $input)
    {
        $dirs = $this->Filesystem->directories($dir);
        $categories = array();
        foreach ($dirs as $dir) {
            $dirArr = explode('/', $dir);
            $dirName = end($dirArr);
            $dirArr = explode('/'. $this->config['root-dir'] .'/', $dir);
            $input['category'] = implode('.', explode('/', end($dirArr)));
            $categories[] = array(
                'name' => $dirName,
                'url' => Request::url() .'?'. http_build_query($input),
                'path' => str_replace($this->basepath, '', $dir),
                'delete-url' => URL::route('dvs-media-category-destroy') .'?'. http_build_query($input),
                'rename-url' => URL::route('dvs-media-category-rename') .'?'. http_build_query($input),
            );
        }

        // sort categories alphabetically...
        usort($categories, array($this, 'sortByCategoryName'));

        return $categories;
    }

    private function buildMediaItems($dir)
    {
        $files = $this->Filesystem->files($dir);

        return $this->buildMediaItemsFromFiles($files);
    }

    private function buildMediaItemsFromFiles($files)
    {
        $newFilesArray = array();
        $lastThumb = null;
        $croppedFiles = array();

        foreach ($files as $file)
        {
            if ($this->passesFilters($file))
            {
                if (strrpos($file, '.' . $this->config['thumb-key'] . '.') !== false){
                    $lastThumb = $file;
                } else if(strrpos($file, '.' . $this->config['crop-key'] . '.') !== false){
                    $croppedFiles[] = $file;
                } else {
                    $fileData = array();
                    $fileData['cropped_files'] = $this->matchingCroppedfiles($file, $croppedFiles);
                    $fileData['thumb'] = $this->getThumbName($file, ($lastThumb != null) ? $lastThumb : null);
                    $fileData['name'] = $this->getFileName($file);
                    $fileData['url'] = $this->getPath($file, $fileData['name']);
                    $fileData['filepath'] = $this->getFilePath($file, $fileData['name']);

                    $newFilesArray[] = $fileData;
                }
            }
        }

        return $newFilesArray;
    }

    private function buildSearchedItems($currentDirectory, $searchFor)
    {
        if (!$searchFor) return array();

        $files = $this->Filesystem->search($currentDirectory, $searchFor);

        return $this->buildMediaItemsFromFiles($files);
    }

    private function passesFilters($file)
    {
        if(isset($this->input['type'])){
            $type = $this->guesser->guess($file);
            if(strpos($type, $this->input['type']) === false){
                return false;
            }
        }

        return true;
    }

    private function matchingCroppedfiles($pathName, &$croppedFiles)
    {
        if(count($croppedFiles)){
            $possibleCroppedFile = $croppedFiles[0];
            $croppedPathName = $this->stringPopExtension($possibleCroppedFile, 3);
            $imagePathName = $this->stringPopExtension($pathName);

            if($croppedPathName == $imagePathName){
                $mathingFiles = $croppedFiles;
                $croppedFiles = [];
                return $mathingFiles;
            }
        }
    }

    private function getFileName($path)
    {
        $pathArr = explode('/', $path);
        return end($pathArr);
    }

    private function getThumbName($pathName, $possibleThumbPathName)
    {
        $thumbPathName = $this->stringPopExtension($possibleThumbPathName, 2);
        $imagePathName = $this->stringPopExtension($pathName);

        if($thumbPathName == $imagePathName){
            return $this->getPath($possibleThumbPathName, $media = false);
        } else {
            return $this->getDefaultThumb($pathName);
        }
    }

    private function stringPopExtension($path, $amnt = 1)
    {
        $pathArr = explode('.', $path);
        array_splice($pathArr, count($pathArr) - $amnt, $amnt);
        return implode('.', $pathArr);
    }

    private function getPath($path, $imageName = null)
    {
        $type = $this->guesser->guess($path);
        $startIndex = strlen(public_path());
        $length = strlen($path); - strlen(public_path());
        return substr($path, $startIndex, $length);
    }

    private function getFilePath($path, $imageName)
    {
        return str_replace(public_path() . '/media', '', $path);
    }

    private function getDefaultThumb($pathName)
    {
        $pathArr = explode('.', $pathName);
        if(isset($this->config['thumbs'][ $pathArr[ count($pathArr) -1 ] ])){
            return URL::asset( $this->config['thumbs'][ $pathArr[ count($pathArr) -1 ] ] );
        } else {
            return URL::asset( $this->config['thumbs']['file']);
        }
    }

    private function sortByCategoryName($category1, $category2)
    {
        if ($category1['name'] == $category2['name']) return 0;

        return $category1['name'] > $category2['name'] ? 1 : -1;
    }
}