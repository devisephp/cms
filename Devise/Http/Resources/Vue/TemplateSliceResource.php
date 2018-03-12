<?php

namespace Devise\Http\Resources\Vue;

use Illuminate\Http\Resources\Json\Resource;

class TemplateSliceResource extends Resource
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
      'id'          => $this->id,
      'slice_id'    => $this->slice_id,
      'type'        => $this->type,
      'label'       => $this->label,
      'name'        => $this->slice->component_name,
      'model_query' => $this->model_query
    ];

    // Relationships
    if ($this->slices->count())
    {
      $data['slices'] = TemplateSliceResource::collection($this->slices);
    }

    return $data;
  }
}
