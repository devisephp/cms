<?php

namespace Devise\Http\Resources\Vue;

use Illuminate\Http\Resources\Json\Resource;

class PageVersionResource extends Resource
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
      'id'          => $this->id,
      'name'        => $this->name,
      'template_id' => $this->template_id,
      'current'     => ($this->page->currentVersion->id == $this->id)
    ];
  }
}