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
      'view'        => $this->view,
      'type'        => $this->type,
      'label'       => $this->label,
      'name'        => $this->component_name,
      'model_query' => $this->model_query,
      'config'      => $this->config
    ];

    // Relationships
    if ($this->slices->count())
    {
      $data['slices'] = TemplateSliceResource::collection($this->slices);
    }

    return $data;
  }
}
