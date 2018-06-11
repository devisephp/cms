<?php

namespace Devise\Http\Resources\Vue;

use Devise\Support\Framework;
use Illuminate\Http\Resources\Json\Resource;

class FieldResource extends Resource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request
   * @return array
   */
  public function toArray($request)
  {
    $value = $this->value;

    if (isset($value->type) && isset($value->url) && ($value->type == 'image' || $value->type == 'file'))
    {
      $storage = Framework::storage();

      if ($this->isMediaRelativePath($value->url))
      {
        $url = $storage->url(trim($value->url, '/'));
        if ($url)
        {
          $value->url = $url;
        }
      }
    }


    return $value;
  }

  public function isMediaRelativePath($path)
  {
    $folder = config('devise.media.root-directory');

    return (strpos($path, $folder) === 0 || strpos($path, $folder) === 1);
  }
}