<?php

namespace Devise\Http\Resources\Vue;

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
      'metadata' => [
        'instance_id' => $this->id,
        'name'        => $this->slice->component_name,
        'label'       => $this->label
      ]
    ];

    // Relationships
    if ($this->slices->count())
    {
      $data['slices'] = SliceInstanceResource::collection($this->slices);
    }

    if ($this->fields->count())
    {
      foreach ($this->fields as $field)
      {
        $data[$field->key] = new FieldResource($field);
      }
    }

    return $data;
  }
}
