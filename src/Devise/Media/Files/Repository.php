<?php namespace Devise\Media\Files;

use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;
use Devise\Media\MediaPaths;
use Devise\Media\Images\Images;
use DvsMediaManager;

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
  /**
   * @var DvsMediaManager
   */
  protected $DvsMediaManager;

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
  public function __construct(DvsMediaManager $DvsMediaManager, Filesystem $Filesystem, MediaPaths $MediaPaths, Images $Image, $Config = null, $Request = null, $URL = null)
  {
    $this->DvsMediaManager = $DvsMediaManager;
    $this->Filesystem = $Filesystem;
    $this->MediaPaths = $MediaPaths;
    $this->config = $Config ?: \Config::get('devise.media-manager');
    $this->Request = $Request ?: \Request::getFacadeRoot();
    $this->URL = $URL ?: \URL::getFacadeRoot();
    $this->guesser = MimeTypeGuesser::getInstance();
    $this->basepath = public_path() . '/' . $this->config['root-dir'] . '/';
    $this->Image = $Image;
  }

  /**
   * Not really sure, gonna revisit this later...
   *
   * @param $results
   * @param null $input
   * @return array
   */
  public function compileIndexData($input = null, $include)
  {
    $data = [];
    $this->input = $input;

    $openLastCategory = isset($input['open-last-category']);
    unset($input['open-last-category']);

    $this->ensureRootDirectoryAvailable();
    $this->setCurrentDirectory($input, $openLastCategory);

    $currentDirectory = $this->getCurrentDirectory($input);

    if (in_array('categories', $include))
    {
      $data['categories'] = $this->buildCategories($currentDirectory, $input);
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

  public function getFileData($file)
  {

    $fileData = array();
    $fileData['id'] = $file->id;
    $fileData['thumb'] = $this->getThumbName(public_path() . $file->media_path);
    $fileData['name'] = $file->name;
    $fileData['url'] = $file->media_path;
    $fileData['size'] = $file->size;
    $fileData['fields'] = json_decode($file->fields);
    $fileData['global_fields'] = json_decode($file->global_fields);
    return $fileData;
  }

  /**
   * Ensures that the media root directory is available
   *
   * @return bool
   */
  private function ensureRootDirectoryAvailable()
  {
    if (!$this->Filesystem->exists(public_path() . '/' . $this->config['root-dir']))
    {
      $this->Filesystem->makeDirectory(public_path() . '/' . $this->config['root-dir'], 0775);
    }

    return true;
  }

  /**
   * [setCurrentDirectory description]
   * @param [type] $input
   */
  private function setCurrentDirectory($input, $openLastCategory)
  {
    $category = isset($input['category']) ? $input['category'] : '';

    if (!$openLastCategory)
    {
      \Session::put('dvs-media-manager-category', $category);
    }
  }

  /**
   * The current directory of the
   * @param $input
   * @return string
   */
  private function getCurrentDirectory($input)
  {
    $category = $this->getCurrentCategory();

    $root = public_path() . '/' . $this->config['root-dir'];

    if ($category)
    {
      $dirPath = implode('/', explode('.', $category));

      return $root . '/' . $dirPath;
    }

    return $root;
  }

  /**
   * Gets the current category
   *
   * @return [type]
   */
  private function getCurrentCategory()
  {
    return \Session::get('dvs-media-manager-category');
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
    foreach ($dirs as $dir)
    {
      $dirArr = explode('/', $dir);
      $dirName = end($dirArr);
      $dirArr = explode('/' . $this->config['root-dir'] . '/', $dir);
      $path = implode('.', explode('/', end($dirArr)));
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
   * Get a list of media items in a directory
   *
   * @param $dir
   * @return array
   */
  private function buildMediaItems($dir)
  {
    $root = public_path() . '/' . $this->config['root-dir'];
    $dir = ltrim(str_replace($root, '', $dir), '/');

    $files = $this->DvsMediaManager
      ->where('directory', $dir)
      ->get();

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
    foreach ($files as $file)
    {
      $newFilesArray[] = $this->getFileData($file);
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
  public function passesFilters($file)
  {
    if (isset($this->input['type']))
    {
      $type = $this->guesser->guess($file);
      if (strpos($type, $this->input['type']) === false)
      {
        return false;
      }
    }

    if (strpos($file, '_opt.txt') !== false)
    {
      return false;
    }

    if (strpos($file, $this->config['thumb-key']) !== false)
    {
      return false;
    }

    if (strpos($file, $this->config['crop-key']) !== false)
    {
      return false;
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
    if (count($croppedFiles))
    {
      $possibleCroppedFile = $croppedFiles[0];
      $croppedPathName = $this->stringPopExtension($possibleCroppedFile, 3);
      $imagePathName = $this->stringPopExtension($pathName);

      if ($croppedPathName == $imagePathName)
      {
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
  private function getThumbName($pathName)
  {
    $relativePath = $this->MediaPaths->makeRelativePath($pathName);

    $paths = $this->MediaPaths->fileVersionInfo($relativePath);

    if (!file_exists($paths->thumbnail) && !$this->attemptThumbGeneration($pathName, $paths->thumbnail))
    {
      return $this->getDefaultThumb($pathName);
    }

    return $paths->thumbnail_url;
  }

  /**
   * @param $path
   * @return string
   */
  private function attemptThumbGeneration($path, $thumbnailPath)
  {
    $type = $this->guesser->guess($path);
    if (strpos($type, 'image') !== false)
    {
      if (!is_dir(dirname($thumbnailPath))) mkdir(dirname($thumbnailPath), 0755, true);

      return $this->Image->makeThumbnailImage($path, $thumbnailPath, $type);
    }

    return false;
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
    $startIndex = strlen(public_path());
    $length = strlen($path);
    -strlen(public_path());

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
    if (isset($this->config['thumbs'][$pathArr[count($pathArr) - 1]]))
    {
      return $this->URL->asset($this->config['thumbs'][$pathArr[count($pathArr) - 1]]);
    } else
    {
      return $this->URL->asset($this->config['thumbs']['file']);
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

  public function getFieldDataForFile($name)
  {
    return DB::table('dvs_fields')
      ->join('dvs_page_versions', 'dvs_page_versions.id', '=', 'dvs_fields.page_version_id')
      ->join('dvs_pages', 'dvs_pages.id', '=', 'dvs_page_versions.page_id')
      ->where(function ($query) {
        $query->where('type', 'file')
          ->orWhere('type', 'image');
      })->where('json_value', 'LIKE', '%' . $name . '%')
      ->select('dvs_fields.id','human_name as field_name', 'title as page_title', 'slug as page_slug')
      ->groupBy('dvs_pages.id')
      ->get();
  }

  public function getGlobalDataForFile($name)
  {
    return DB::table('dvs_global_fields')
      ->where(function ($query) {
        $query->where('type', 'file')
          ->orWhere('type', 'image');
      })->where('json_value', 'LIKE', '%' . $name . '%')
      ->select('dvs_global_fields.id','human_name as field_name')
      ->get();
  }
}