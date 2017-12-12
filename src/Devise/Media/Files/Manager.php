<?php namespace Devise\Media\Files;

use Devise\Media\Categories\CategoryPaths;
use Devise\Media\Images\Images;
use Devise\Media\MediaPaths;
use Devise\Media\Helpers\Caption;
use DvsMediaManager;

/**
 * Class Manager
 * @package Devise\Media\Files
 */
class Manager
{
  /**
   * @var Filesystem
   */
  protected $Filesystem;

  /**
   * @var CategoryPaths
   */
  protected $CategoryPaths;

  /**
   * @var Image
   */
  protected $Image;

  protected $DvsMediaManager;

  /**
   * Construct a new File manager
   *
   * @param Filesystem $Filesystem
   * @param CategoryPaths $CategoryPaths
   * @param Image $Image
   * @param Caption $Caption
   */
  public function __construct(DvsMediaManager $DvsMediaManager, Filesystem $Filesystem, CategoryPaths $CategoryPaths, MediaPaths $MediaPaths, Images $Image, Caption $Caption, $Config = null)
  {
    $this->DvsMediaManager = $DvsMediaManager;
    $this->Filesystem = $Filesystem;
    $this->CategoryPaths = $CategoryPaths;
    $this->MediaPaths = $MediaPaths;
    $this->Image = $Image;
    $this->Caption = $Caption;
    $this->basepath = public_path();
    $this->Config = $Config ?: \Config::getFacadeRoot();
  }

  /**
   * Saves the uploaded file to the media directory
   *
   * @param $input
   * @return DvsMediaManager
   */
  public function saveUploadedFile($input)
  {
    $file = array_get($input, 'file', null);

    if (is_null($file))
    {
      return false;
    }

    $originalName = $file->getClientOriginalName();
    $localPath = (isset($input['directory'])) ? $this->CategoryPaths->fromDot($input['directory']) : '';
    $serverPath = $this->CategoryPaths->serverPath($localPath);

    $newName = $this->createFile($file, $serverPath, $originalName);

    if ($this->Image->canMakeThumbnailFromFile($file))
    {
      $thumbnailPath = $this->getThumbnailPath($localPath . '/' . $newName);
      if (!is_dir(dirname($thumbnailPath))) mkdir(dirname($thumbnailPath), 0755, true);
      $this->Image->makeThumbnailImage($serverPath . $newName, $thumbnailPath, $file->getClientMimeType());
    }

    $mm = new DvsMediaManager();
    $mm->directory = $localPath;
    $mm->name = $file->getClientOriginalName();
    $mm->size = $file->getClientSize();
    $mm->fields = '[]';
    $mm->global_fields = '[]';
    $mm->save();

    return $mm;
  }

  /**
   * Renames an uploaded file
   * @todo should be looking up by id
   *
   * @param  string $filepath
   * @param  string $newpath
   * @return void
   */
  public function renameUploadedFile($filepath, $newpath)
  {
    if ($this->Caption->exists($this->basepath . $filepath))
    {
      $oldCptPath = $this->MediaPaths->imageCaptionPath($this->basepath . $filepath);
      $newCptPath = $this->MediaPaths->imageCaptionPath($this->basepath . $newpath);

      $this->Filesystem->rename($oldCptPath, $newCptPath);
    }

    $this->Filesystem->rename($this->basepath . $filepath, $this->basepath . $newpath);

    $parts = explode('/', $filepath);

  }

  /**
   * Remove uploaded files from the /media directory
   * @todo should be looking up by id
   *
   * @param  string $filepath
   * @return void
   */
  public function removeUploadedFile($id)
  {
    $file = $this->DvsMediaManager
      ->findOrFail($id);

    $this->Filesystem
      ->delete($this->basepath . $file->media_path);

    $file->delete();
  }

  /**
   * Change this
   * @param $currentName
   * @return string
   */
  private function getThumbnailPath($currentName)
  {
    return $this->MediaPaths->fileVersionInfo('/media/' . $currentName)->thumbnail;
  }

  /**
   * Checks for file existence and then creates file.. if the file
   * already exists we create a new file (clone)
   *
   * @param  File $file
   * @param  string $serverPath
   * @param  string $originalName
   * @return string
   */
  private function createFile($file, $serverPath, $originalName)
  {
    $newName = $originalName;

    $info = pathinfo($newName);

    $sanity = 0;

    while (file_exists($serverPath . '/' . $newName))
    {
      $dir = $info['dirname'] === '.' ? '' : $info['dirname'];
      $newName = $dir . $info['filename'] . '.copy.' . $info['extension'];

      if ($sanity++ > 5) throw new \Exception("You've got a lot of copies of this file... I'm going to stop trying to make copies...");
    }

    $file->move($serverPath, $newName);

    return $newName;
  }
}