<?php

namespace Devise\Resources\Api;

use Illuminate\Http\Resources\Json\Resource;

class SliceInstanceResource extends Resource
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
      'id'   => $this->slice->id,
      'name' => $this->slice->component_name,
    ];

    // Relationships
    if ($this->slice && $this->slice->slices->count())
    {
      $data['slices'] = SliceInstanceResource::collection($this->slice->slices);
    }

    if($this->fields->count())
    {
      $data['fields'] = [];
      foreach ($this->fields as $field)
      {
        $data['fields'][$field->key] = new FieldResource($field);
      }
    }

    return $data;
  }
}