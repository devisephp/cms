<?php

namespace Devise\Resources\Api;

use Illuminate\Http\Resources\Json\Resource;

class TemplateResource extends Resource
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
      'name' => $this->name,
      'slices' => SliceInstanceResource::collection($this->slices),
    ];
  }
}