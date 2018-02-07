<?php

namespace Devise\Resources\Vue;

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
        'title'       => $this->meta_title,
        'description' => $this->meta_description,
        'canonical'   => $this->canonical,
      ],
      'slices' => []
    ];

    // Relationships
    if ($this->version->template)
    {
      $data['slices'] = SliceInstanceResource::collection($this->version->template->slices);
    }

    return $data;
  }
}