<?php

namespace Devise\Http\Resources\Vue;

use Devise\Models\Repository as ModelRepository;

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
        'name'        => $this->templateSlice->component_name,
        'type'        => $this->templateSlice->type,
        'label'       => $this->templateSlice->label,
        'enabled'     => $this->enabled,
        'childmeta'   => $childMeta
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
    parse_str($modelSlice->model_query, $input);

    $repository = App::make(ModelRepository::class);

    $records = $repository
      ->runQuery($input);

    $all = [];
    foreach ($records as $record)
    {
      $data['metadata'] = [
        'instance_id' => 0,
        'name'        => $modelSlice->component_name,
        'type'        => $modelSlice->type,
        'label'       => $modelSlice->label,
        'enabled'     => 1
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
