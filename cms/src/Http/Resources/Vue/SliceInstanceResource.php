<?php

namespace Devise\Http\Resources\Vue;

use Devise\ModelQueries;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;

class SliceInstanceResource extends JsonResource
{

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
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

    /**
     * @param $data
     */
    private function setChildSlices(&$data)
    {
        $data['slices'] = SliceInstanceResource::collection($this->slices);
    }

    /**
     * @param $data
     */
    private function setModelSlices(&$data)
    {
        $records = ModelQueries::runQuery($this->model_query);

        $all = [];
        if ($records)
        {
            if ($records instanceof Collection || $records instanceof SupportCollection || $records instanceof LengthAwarePaginator)
            {
                foreach ($records as $record)
                {
                    $all[] = $record->getSliceData($this);
                }
            } else
            {
                $all[] = $records->getSliceData($this);
            }
        }

        $data['slices'] = $all;
    }

    /**
     * @param $data
     */
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
