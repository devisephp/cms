<?php

namespace Devise\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends Resource
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
      'name'       => $this->name,
      'email'      => $this->email,
      'created_at' => ($this->created_at) ? $this->created_at->format('Y-m-d H:i:s') : '',
      'updated_at' => ($this->updated_at) ? $this->updated_at->format('Y-m-d H:i:s') : ''
    ];
  }
}