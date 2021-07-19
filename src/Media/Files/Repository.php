<?php namespace Devise\Media\Files;

use Devise\Media\Directories\DirectoryPaths;

use Devise\Models\DvsField;
use Devise\Sites\SiteDetector;
use Devise\Support\Framework;
use Devise\Media\Directories\Manager as DirectoriesManager;

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

    private $ImageAlts;

    protected $Storage;

    /**
     *
     */
    public function __construct(SiteDetector $SiteDetector, DirectoryPaths $CategoryPaths, ImageAlts $ImageAlts, Framework $Framework)
    {
        $this->SiteDetector = $SiteDetector;
        $this->CategoryPaths = $CategoryPaths;
        $this->ImageAlts = $ImageAlts;

        $this->Storage = $Framework->storage->disk(config('devise.media.disk'));
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


        return $data;
    }

    public function getFileData($file, $addUsageData = false)
    {
        $fileData = array();

        $fileData['name'] = basename($file);
        $fileData['url'] = '/storage/' . $file;
        $fileData['type'] = 'file';
        $fileData['alt'] = $this->ImageAlts->get($fileData['url']);

        if ($this->isImageExtension($file))
        {
            $fileData['type'] = 'image';
        }

        if ($addUsageData)
        {
            $search = '%\\/storage' . str_replace('/', '\\\\\\/', $file) . '%';
            $pages = DvsField::where('json_value', 'like', $search)
                ->join('dvs_slice_instances', 'dvs_slice_instances.id', '=', 'dvs_fields.slice_instance_id')
                ->join('dvs_page_versions', 'dvs_page_versions.id', '=', 'dvs_slice_instances.page_version_id')
                ->join('dvs_pages', 'dvs_pages.id', '=', 'dvs_page_versions.page_id')
                ->select("dvs_pages.id", 'dvs_pages.title', 'dvs_pages.slug')
                ->groupBy('dvs_pages.id')
                ->get();

            $fileData['pages'] = $pages->toArray();
        }

        return $fileData;
    }

    private function isImageExtension($path)
    {
        $allowed = ['jpg', 'jpeg', 'jpe', 'jif', 'jfif', 'jfi', 'png', 'gif', 'webp', 'tiff', 'tif', 'jp2', 'j2k', 'jpf', 'jpx', 'jpm', 'mj2'];
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return in_array($ext, $allowed);
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
            if (DirectoriesManager::dirPermitted($dir))
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
    public function buildSearchedItems($searchFor, $path = '')
    {
        $mediaDir = $this->CategoryPaths->serverPath($path);

        $allFiles = $this->Storage->allFiles($mediaDir);

        $searchFor = str_replace(' ', ')(?=.*', trim(preg_quote($searchFor, "/")));
        $matchingFiles = preg_grep('/(?=.*' . $searchFor . ')/i', $allFiles);

        return $this->buildMediaItemsFromFiles($matchingFiles);
    }

    /**
     *
     */
    private function buildMediaItemsFromFiles($files)
    {
        $newFilesArray = array();
        foreach ($files as $file)
        {
            if ($this->passesFilters($file))
                $newFilesArray[] = $this->getFileData($file);
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
            $type = $this->Storage->mimeType($file);
            if (strpos($type, $this->input['type']) === false)
                return false;
        }

        if (strpos($file, 'DS_Store') !== false)
            return false;

        return DirectoriesManager::dirPermitted($file);
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
