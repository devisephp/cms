<?php

namespace Devise\Http\Resources\Api;

use Illuminate\Http\Resources\Json\Resource;

class PageResource extends Resource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request
   * @return array
   */
  public function toArray($request)
  {
    $data = [
      'meta'   => [
        'id'          => $this->id,
        'title'       => $this->title,
        'canonical'   => $this->canonical,
      ]
    ];

    return $data;
  }
}