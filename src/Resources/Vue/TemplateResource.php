<?php

namespace Devise\Resources\Vue;

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
      'id'       => $this->id,
      'name'     => $this->name
    ];
  }
}