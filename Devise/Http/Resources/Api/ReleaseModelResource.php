<?php

namespace Devise\Http\Resources\Api;

use Illuminate\Http\Resources\Json\Resource;

class ReleaseModelResource extends Resource
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
      'id'         => $this->id,
      'model'       => $this->name,
    ];

    $data['changes'] = [];

    foreach ($this->releases as $release)
    {
      $data['changes'][] = [
        'id' => $release->id,
        'description' => $release->change_description,
        'updated_at' => $release->updated_at->format('Y-m-d H:i:s')
      ];
    }

    return $data;
  }

  private function getDescription($model_name)
  {

  }
}
