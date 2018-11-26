<?php namespace Devise\Media\Files;

use Devise\Media\Categories\CategoryPaths;

use Devise\Sites\SiteDetector;
use Devise\Support\Framework;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;

/**
 * Class Repository builds a complex array of data around the file structure
 * of the media manager. This let's us fetch a lot of things regarding the
 * file system around the media manager
 *
 * @todo investigate repo, might be room for refactor
 * @package Devise\Media\Files
 */
class Repository
{
    private $SiteDetector;

    private $CategoryPaths;

    private $input;

    private $guesser;

    protected $Storage;

    /**
     *
     */
    public function __construct(SiteDetector $SiteDetector, CategoryPaths $CategoryPaths, Framework $Framework)
    {
        $this->SiteDetector = $SiteDetector;
        $this->CategoryPaths = $CategoryPaths;

        $this->Storage = $Framework->storage->disk(config('devise.media.disk'));

        $this->guesser = MimeTypeGuesser::getInstance();
    }

    /**
     *
     */
    public function getIndex($input, $include)
    {
        $data = [];
        $this->input = $input;

        $categoryPath = (isset($input['category'])) ? $this->CategoryPaths->fromDot($input['category']) : '';
        $currentDirectory = $this->CategoryPaths->serverPath($categoryPath);

        if (in_array('categories', $include))
        {
            $data['categories'] = $this->buildCategories($currentDirectory);
        }

        if (in_array('media-items', $include))
        {
            $data['media-items'] = $this->buildMediaItems($currentDirectory);
        }

        if (in_array('searched-items', $include))
        {
            $data['searched-items'] = $this->buildSearchedItems($currentDirectory, array_get($input, 'search'));
        }


        return $data;
    }

    public function getFileData($file, $addSearchableData = false)
    {
        $fileData = array();

        $fileData['name'] = basename($file);
        $fileData['url'] = $this->Storage->url($file);
        $fileData['type'] = 'file';

        if ($addSearchableData)
        {
            $pathParts = explode('/', $file);
            array_shift($pathParts); // removing media dir

            $fileData['search'] = implode(' ', $pathParts);

            array_pop($pathParts); // removing file name
            $fileData['directories'] = $pathParts;
        }

        $type = $this->guesser->guess($this->Storage->path($file));
        if (strpos($type, 'image') !== false)
        {
            $fileData['type'] = 'image';
        }

        return $fileData;
    }

    /**
     *
     */
    private function buildCategories($dir)
    {
        $dirs = $this->Storage->directories($dir);

        $categories = array();
        foreach ($dirs as $dir)
        {
            $dirArr = explode('/', $dir);
            $dirName = end($dirArr);

            $path = str_replace($this->CategoryPaths->basePath() . '/', '', $dir);

            $path = implode('.', explode('/', $path));
            $categories[] = array(
                'name' => $dirName,
                'path' => $path
            );
        }

        // sort categories alphabetically...
        usort($categories, array($this, 'sortByCategoryName'));

        return $categories;
    }

    /**
     *
     */
    private function buildMediaItems($dir)
    {
        $files = $this->Storage->files($dir);

        return $this->buildMediaItemsFromFiles($files);
    }

    /**
     *
     */
    public function buildSearchableMediaItems()
    {
        $mediaDir = $this->CategoryPaths->serverPath('');

        $files = $this->Storage->allFiles($mediaDir);

        return $this->buildMediaItemsFromFiles($files, true);
    }

    /**
     *
     */
    private function buildMediaItemsFromFiles($files, $addSearchableData = false)
    {
        $newFilesArray = array();
        foreach ($files as $file)
        {
            if ($this->passesFilters($file))
                $newFilesArray[] = $this->getFileData($file, $addSearchableData);
        }

        return $newFilesArray;
    }

    /**
     *
     */
    private function passesFilters($file)
    {
        if (isset($this->input['type']))
        {
            $type = $this->guesser->guess($this->Storage->path($file));
            if (strpos($type, $this->input['type']) === false)
                return false;
        }

        if (strpos($file, 'DS_Store') !== false)
            return false;

        return true;
    }

    /**
     *
     */
    private function buildSearchedItems($currentDirectory, $searchFor)
    {
        if (!$searchFor) return array();

        $files = $this->Storage->search($currentDirectory, $searchFor);

        return $this->buildMediaItemsFromFiles($files);
    }

    /**
     *
     */
    private function sortByCategoryName($category1, $category2)
    {
        if ($category1['name'] == $category2['name']) return 0;

        return $category1['name'] > $category2['name'] ? 1 : -1;
    }
}
