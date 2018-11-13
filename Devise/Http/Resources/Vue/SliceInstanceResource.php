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
                'type'        => $this->type,
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
        if ($records)
        {
            if (is_a($records, $input['class']))
            {
                $all[] = $this->getModelSliceData($records);
            } else
            {
                foreach ($records as $record)
                {
                    $all[] = $this->getModelSliceData($record);
                }
            }
        }

        $data['slices'] = $all;
    }

    private function getModelSliceData($record)
    {
        $data['metadata'] = [
            'instance_id' => 0,
            'name'        => $this->component_name,
            'label'       => $this->label,
            'view'        => $this->view,
            'model_query' => $this->model_query,
            'placeholder' => false,
        ];

        // slice should be a property of the model. it's an array of fields that will end up in the slice
        foreach ($record->slice as $field)
        {
            $data[$field] = $record->$field;
        }

        return $data;
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
