<?php

namespace Devise\Http\Resources\Vue;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\App;

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
    $childConfig = $this->childConfig;

    $childMeta = ($childConfig) ? [
      'id'   => $childConfig->id,
      'type' => $childConfig->type
    ] : null;

    $data = [
      'metadata' => [
        'instance_id' => $this->id,
        'name'        => $this->templateSlice->slice->component_name,
        'label'       => $this->templateSlice->label,
        'enabled'     => $this->enabled,
        'childmeta'  => $childMeta
      ]
    ];

    // Relationships
    if ($this->slices->count())
    {
      $data['slices'] = SliceInstanceResource::collection($this->slices);
    }

    if ($childConfig && $childConfig->type == 'model')
    {
      $data['slices'] = $this->setModelSlices($childConfig);
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

  private function setModelSlices($modelSlice)
  {
    $model = App::make($modelSlice->model);

    $records = $model->get();

    $all = [];
    foreach ($records as $record)
    {
      $data['metadata'] = [
        'name'    => $modelSlice->slice->component_name,
        'label'   => $modelSlice->label,
        'enabled' => 1
      ];

      foreach ($record->slice as $field)
      {
        $data[$field] = $record->$field;
      }

      $all[] = $data;
    }

    return $all;
  }
}
