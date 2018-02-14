<?php

namespace Devise\Http\Resources\Vue;

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
      'title'              => $this->meta_title,
      'description'        => $this->meta_description,
      'canonical'          => $this->canonical,
      'ab_testing_enabled' => $this->ab_testing_enabled,
      'slices'             => []
    ];

    // Relationships
    if ($this->liveVersion && $this->liveVersion->template)
    {
      $data['slices'] = SliceInstanceResource::collection($this->liveVersion->slices);
    }

    return $data;
  }
}