<?php

namespace Devise\Http\Resources\Api;

use Illuminate\Http\Resources\Json\Resource;

class SliceResource extends Resource
{
  /**
   * Transform the resource into an array.
   *
   * @param  \Illuminate\Http\Request
   * @return array
   */
  public function toArray($request)
  {
    $this->getComponentCodeAttribute();

    return [
      'id'             => $this->id,
      'name'           => $this->name,
      'component'      => $this->component_name,
      'view'           => $this->view,
      'has_child_slot' => $this->has_child_slot,
      'created_at'     => $this->created_at->format('Y-m-d H:i:s'),
      'updated_at'     => $this->updated_at->format('Y-m-d H:i:s')
    ];
  }
}
