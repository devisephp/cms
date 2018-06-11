<?php

namespace Devise\Models;

use Devise\Sites\SiteDetector;
use Devise\Support\Framework;
use Illuminate\Http\File;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Imagick;

class DvsMedia extends Model
{
  public $table = 'dvs_media';

  private $frameworkStorage = null;

  /**
   *
   */
  public function getUrlAttribute()
  {
    return $this->storage()->url($this->media_path);
  }

  /**
   *
   */
  public function getThumbnailUrlAttribute()
  {
    return $this->storage()->exists($this->thumbnail_path) ? $this->storage()->url($this->thumbnail_path) : null;
  }

  /**
   *
   */
  public function getMediaPathAttribute()
  {
    return $this->media_directory . $this->name;
  }

  /**
   *
   */
  public function getThumbnailPathAttribute()
  {
    return $this->media_directory . $this->thumbnail_filename;
  }

  /**
   *
   */
  public function getCaptionPathAttribute()
  {
    return $this->media_directory . $this->caption_filename;
  }

  /**
   *
   */
  public function getMediaDirectoryAttribute()
  {
    $siteDetector = App::make(SiteDetector::class);
    $site = $siteDetector->current();

    if ($this->directory == "")
    {
      return 'media/' . $site->domain . '/';
    }

    return 'media/' . $site->domain . '/' . $this->directory . '/';
  }

  /**
   *
   */
  public function getCaptionFilenameAttribute()
  {
    $parts = explode('.', $this->name);
    array_pop($parts);// dropping extension
    $pathWithoutExtension = implode('.', $parts);

    return $pathWithoutExtension . '.txt';
  }

  /**
   *
   */
  public function getThumbnailFilenameAttribute()
  {
    $parts = explode('.', $this->name);
    $extension = array_pop($parts);// dropping extension
    $pathWithoutExtension = implode('.', $parts);

    return $pathWithoutExtension . '-dvs-thumb.' . $extension;
  }

  /**
   *
   */
  public function saveUploadTo($file, $serverPath)
  {
    $this->storage()->putFileAs($serverPath, $file, $file->getClientOriginalName(), 'public');

    if ($this->canMakeThumbnailFromFile($file))
      $this->makeThumbnailImage($serverPath, $file);
  }

  public function delete()
  {
    if($this->storage()->exists($this->thumbnail_path)){
      $this->storage()->delete($this->thumbnail_path);
    }

    if($this->storage()->exists($this->media_path)){
      $this->storage()->delete($this->media_path);
    }

    return parent::delete();
  }

  /**
   *
   */
  private function canMakeThumbnailFromFile($file)
  {
    $mime = $file->getClientMimeType();

    return (strpos($mime, 'image') !== false && extension_loaded('imagick'));
  }

  /**
   *
   */
  private function makeThumbnailImage($serverPath, $file)
  {
    $tempThumbPath = storage_path() . '/' . time();

    $file = $this->storage()->get($serverPath . $file->getClientOriginalName());

    $image = new Imagick();
    $image->readImageBlob($file);
    $image->cropThumbnailImage(200, 200);
    $image->setImageCompressionQuality(90);

    $this->saveTemp($image, $tempThumbPath);

    $thumbnail = new File($tempThumbPath);

    if ($thumbnail)
      $this->storage()->putFileAs($serverPath, $thumbnail, $this->thumbnail_filename, 'public');

    unlink($tempThumbPath);
  }

  /**
   *
   */
  private function saveTemp(Imagick $image, $path)
  {
    if (!is_dir(dirname($path)))
    {
      mkdir(dirname($path), 0755, true);
    }

    if (!file_exists($path))
    {
      $image->writeImage($path);
    }

    return $path;
  }

  /**
   *
   */
  private function storage()
  {
    return Framework::storage();
  }
}