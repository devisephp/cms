<?php

namespace Devise\Http\Resources\Api;

use Illuminate\Http\Resources\Json\Resource;

class RedirectResource extends Resource
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
      'site_id'    => $this->site_id,
      'from_url'   => $this->from_url,
      'to_url'     => $this->to_url,
      'created_at' => $this->created_at->format('Y-m-d H:i:s'),
      'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
    ];
  }
}
