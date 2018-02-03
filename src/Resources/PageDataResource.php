<?php

namespace Devise\Resources;

use Illuminate\Http\Resources\Json\Resource;

class PageDataResource extends Resource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request
   * @return array
   */
  public function toArray($request)
  {
    return [
      'id'         => $this->id,
      'title'       => $this->title,

      // Relationships
      'version' => new PageVersionResource($this->version)
    ];
  }
}