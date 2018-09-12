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
                'label'       => $this->label,
                'view'        => $this->view,
                'model_query' => $this->model_query,
                'placeholder' => ($this->has_model_query) ? false : true,
            ],
            'settings' => $this->settings
        ];

        if ($this->has_model_query)
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
        $data['slices'] = SliceInstanceResource::collection($this->slices);
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
