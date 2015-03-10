<?php namespace Devise\Media\Files;

use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;
use Devise\Media\MediaPaths;

/**
 * Class Repository builds a complex array of data around the file structure
 * of the media manager? This let's us fetch a lot of things regarding the
 * file system around the media manager
 *
 * @todo investigate repo, might be room for refactor

 * @package Devise\Media\Files
 */
class Repository
{
    /**
     * @var Filesystem
     */
    protected $Filesystem;

    /**
     * @var
     */
    protected $config;

    /**
     * @var
     */
    protected $input;

    /**
     * Constructs a new repository
     *
     * @param Filesystem $Filesystem
     * @param null $Config
     * @param null $Request
     * @param null $URL
     */
    public function __construct(Filesystem $Filesystem, MediaPaths $MediaPaths, $Config = null, $Request = null, $URL = null)
    {
        $this->Filesystem = $Filesystem;
        $this->MediaPaths = $MediaPaths;
        $this->config = $Config ?: \Config::get('devise.media-manager');
        $this->Request = $Request?: \Request::getFacadeRoot();
        $this->URL = $URL ?: \URL::getFacadeRoot();
        $this->guesser = MimeTypeGuesser::getInstance();
        $this->basepath = public_path().'/'.$this->config['root-dir'] . '/';
    }

    /**
     * Not really sure, gonna revisit this later...
     *
     * @param $results
     * @param null $input
     * @return array
     */
    public function compileIndexData($input = null)
    {
        $data = [];
        $this->input = $input;

        $this->ensureRootDirectoryAvailable();

        $currentDirectory = $this->getCurrentDirectory($input);
        $data['crumbs'] = $this->buildCrumbs( $input );
        $data['categories'] = $this->buildCategories( $currentDirectory, $input );
        $data['media-items'] = $this->buildMediaItems( $currentDirectory, $input );
        $data['searched-items'] = $this->buildSearchedItems( $currentDirectory, array_get($input, 'search'));

        return $data;
    }

    /**
     * Ensures that the media root directory is available
     *
     * @return bool
     */
    private function ensureRootDirectoryAvailable()
    {
        if(!$this->Filesystem->exists( public_path().'/'. $this->config['root-dir'] ))
        {
            $this->Filesystem->makeDirectory(public_path().'/'. $this->config['root-dir'], 0775);
        }

        return true;
    }

    /**
     * The current directory of the
     * @param $input
     * @return string
     */
    private function getCurrentDirectory($input)
    {
        if(!isset($input['category'])){
            return public_path().'/'.$this->config['root-dir'];
        } else {
            $dirPath = implode('/', explode('.', $input['category']));
            return public_path().'/'.$this->config['root-dir'] . '/' . $dirPath;
        }
    }

    /**
     * Builds the bread crumbs for a specific directory?...
     *
     * @param $input
     * @return array
     */
    private function buildCrumbs($input)
    {
        $crumbs = array(
            array(
                'name' => 'Main',
                'url' => $this->Request->url() .'?'. http_build_query(array_except($input, 'category'))
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
                    'url' => $this->Request->url() .'?'. http_build_query($input)
                );
            }

        }

        return $crumbs;
    }

    /**
     * @param $dir
     * @param $input
     * @return array
     */
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
                'url' => $this->Request->url() .'?'. http_build_query($input),
                'path' => str_replace($this->basepath, '', $dir),
                'delete-url' => $this->URL->route('dvs-media-category-destroy') .'?'. http_build_query($input),
                'rename-url' => $this->URL->route('dvs-media-category-rename') .'?'. http_build_query($input),
            );
        }

        // sort categories alphabetically...
        usort($categories, array($this, 'sortByCategoryName'));

        return $categories;
    }

    /**
     * Get a list of media items in a directory
     *
     * @param $dir
     * @return array
     */
    private function buildMediaItems($dir)
    {
        $files = $this->Filesystem->files($dir);

        return $this->buildMediaItemsFromFiles($files);
    }

    /**
     * Get a list of media items from files
     *
     * @param $files
     * @return array
     */
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
                    $fileData['thumb'] = $this->getThumbName($file, $lastThumb);
                    $fileData['name'] = $this->getFileName($file);
                    $fileData['url'] = $this->getPath($file, $fileData['name']);
                    $fileData['filepath'] = $this->getFilePath($file, $fileData['name']);

                    $newFilesArray[] = $fileData;
                }
            }
        }

        return $newFilesArray;
    }

    /**
     * Get
     * @param $currentDirectory
     * @param $searchFor
     * @return array
     */
    private function buildSearchedItems($currentDirectory, $searchFor)
    {
        if (!$searchFor) return array();

        $files = $this->Filesystem->search($currentDirectory, $searchFor);

        return $this->buildMediaItemsFromFiles($files);
    }

    /**
     * @param $file
     * @return bool
     */
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

    /**
     * @param $pathName
     * @param $croppedFiles
     * @return mixed
     */
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

    /**
     * @param $path
     * @return mixed
     */
    private function getFileName($path)
    {
        $pathArr = explode('/', $path);
        return end($pathArr);
    }

    /**
     * @param $pathName
     * @param $possibleThumbPathName
     * @return string
     */
    private function getThumbName($pathName, $possibleThumbPathName)
    {
        $relativePath = $this->MediaPaths->makeRelativePath($pathName);

        $paths = $this->MediaPaths->fileVersionInfo($relativePath);

        return file_exists($paths->thumbnail) ? $paths->thumbnail_url : $this->getDefaultThumb($pathName);
    }

    /**
     * @param $path
     * @param int $amnt
     * @return string
     */
    private function stringPopExtension($path, $amnt = 1)
    {
        $pathArr = explode('.', $path);
        array_splice($pathArr, count($pathArr) - $amnt, $amnt);
        return implode('.', $pathArr);
    }

    /**
     * @param $path
     * @param null $imageName
     * @return string
     */
    private function getPath($path, $imageName = null)
    {
        $type = $this->guesser->guess($path);
        $startIndex = strlen(public_path());
        $length = strlen($path); - strlen(public_path());
        return substr($path, $startIndex, $length);
    }

    /**
     * @param $path
     * @param $imageName
     * @return mixed
     */
    private function getFilePath($path, $imageName)
    {
        return str_replace(public_path() . '/media', '', $path);
    }

    /**
     * @param $pathName
     * @return mixed
     */
    private function getDefaultThumb($pathName)
    {
        $pathArr = explode('.', $pathName);
        if(isset($this->config['thumbs'][ $pathArr[ count($pathArr) -1 ] ])){
            return $this->URL->asset( $this->config['thumbs'][ $pathArr[ count($pathArr) -1 ] ] );
        } else {
            return $this->URL->asset( $this->config['thumbs']['file']);
        }
    }

    /**
     * @param $category1
     * @param $category2
     * @return int
     */
    private function sortByCategoryName($category1, $category2)
    {
        if ($category1['name'] == $category2['name']) return 0;

        return $category1['name'] > $category2['name'] ? 1 : -1;
    }
}