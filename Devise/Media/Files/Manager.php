<?php namespace Devise\Media\Files;

use Devise\Media\Categories\CategoryPaths;
use Devise\Models\DvsMedia;
use Devise\Sites\SiteDetector;
use Devise\Support\Framework;
use Illuminate\Http\UploadedFile;

/**
 * Class Manager
 * @package Devise\Media\Files
 */
class Manager
{
  private $DvsMedia;

  private $CategoryPaths;

  private $SiteDetector;

  /**
   *
   */
  public function __construct(DvsMedia $DvsMedia, CategoryPaths $CategoryPaths, SiteDetector $SiteDetector, Framework $Framework)
  {
    $this->DvsMedia = $DvsMedia;
    $this->CategoryPaths = $CategoryPaths;
    $this->SiteDetector = $SiteDetector;
  }

  /**
   *
   */
  public function saveUploadedFile($input)
  {
    $categoryPath = (isset($input['directory'])) ? $this->CategoryPaths->fromDot($input['directory']) : '';
    $file = array_get($input, 'file', null);

    $serverPath = $this->CategoryPaths->serverPath($categoryPath);

    $mm = new DvsMedia();
    $mm->directory = $categoryPath;
    $mm->name = $file->getClientOriginalName();
    $mm->size = $file->getClientSize();
    $mm->used_count = 0;

    $site = $this->SiteDetector->current();
    $site->media()->save($mm, ['default' => 0]);

    $mm->saveUploadTo($file, $serverPath);

    return $mm;
  }

  /**
   *
   */
  public function removeUploadedFile($id)
  {
    $site = $this->SiteDetector->current();

    $file = $this->DvsMedia
      ->findOrFail($id);

    $site->media()->detach($id);

    $file->delete();
  }

}
