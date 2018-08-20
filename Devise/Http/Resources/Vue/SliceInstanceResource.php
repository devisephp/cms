<?php

namespace Devise\Http\Resources\Vue;

use Devise\Models\Repository as ModelRepository;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\App;

class SliceInstanceResource extends Resource
{

    public function toArray($request)
    {
        $data = [
            'metadata' => [
                'instance_id' => $this->id,
                'name'        => $this->component_name,
                'type'        => $this->type,
                'label'       => $this->label,
                'view'        => $this->view,
                'model_query' => $this->model_query,
                'placeholder' => ($this->type == 'single' || $this->parent_type == 'repeats') ? false : true,
            ],
            'settings' => $this->settings
        ];

        if ($this->type == 'model')
        {
            $this->setModelSlices($data);
        } else
        {
            $this->setChildSlices($data);
        }

        $this->setFieldValues($data);

        return $data;
    }

    private function setChildSlices(&$data)
    {
        if ($this->slices->count())
        {
            $this->slices->map(function ($slice) {
                $slice->parent_type = $this->type;

                return $slice;
            });

            $data['slices'] = SliceInstanceResource::collection($this->slices);
        }
    }

    private function setModelSlices(&$data)
    {
        parse_str($this->model_query, $input);

        $repository = App::make(ModelRepository::class);

        $records = $repository
            ->runQuery($input);

        $all = [];
        foreach ($records as $record)
        {
            $data['metadata'] = [
                'instance_id' => 0,
                'name'        => $this->component_name,
                'type'        => $this->type,
                'label'       => $this->label,
                'view'        => $this->view,
                'model_query' => $this->model_query,
                'placeholder' => false,
            ];

            foreach ($record->slice as $field)
            {
                $data[$field] = $record->$field;
            }

            $all[] = $data;
        }

        $data['slices'] = $all;
    }

    private function setFieldValues(&$data)
    {
        if ($this->fields->count())
        {
            foreach ($this->fields as $field)
            {
                $data[$field->key] = new FieldResource($field);
            }
        }
    }
}
