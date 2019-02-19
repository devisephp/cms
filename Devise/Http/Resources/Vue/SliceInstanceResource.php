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
                'instance_id'    => $this->id,
                'name'           => $this->component_name,
                'label'          => $this->label,
                'view'           => $this->view,
                'type'           => $this->type,
                'model_query'    => $this->model_query,
                'has_child_slot' => $this->has_child_slot,
                'placeholder'    => ($this->has_model_query) ? false : true,
            ]
        ];

        if ($this->has_model_query)
        {
            $this->setModelSlices($data);
        } else
        {
            $this->setChildSlices($data);
        }

        $this->setFieldValues($data);

        // setting this last because of some legacy code
        $data['settings'] = $this->settings;

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
                $all[] = $records->getSliceData($this);
            } else
            {
                foreach ($records as $record)
                {
                    $all[] = $record->getSliceData($this);
                }
            }
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
