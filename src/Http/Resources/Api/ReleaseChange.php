<?php

namespace Devise\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ReleaseChange extends JsonResource
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
      'description' => $this->description,
      'by' => ($this->user) ? $this->user->name : 'Unknown',
      'date' => $this->created_at->format('Y-m-d H:i:s')
    ];
  }
}
