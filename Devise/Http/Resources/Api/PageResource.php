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
      'id'                 => $this->id,
      'title'              => $this->title,
      'slug'               => $this->slug,
      'canonical'          => $this->canonical,
      'ab_testing_enabled' => $this->ab_testing_enabled,

      // Relationships
      'versions'           => PageVersionResource::collection($this->whenLoaded('versions')),

      'created_at' => $this->created_at->format('Y-m-d H:i:s'),
      'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
    ];

    return $data;
  }
}