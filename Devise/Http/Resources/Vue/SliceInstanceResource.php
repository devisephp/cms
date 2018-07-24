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
        $data = [
            'metadata' => [
                'instance_id' => $this->id,
                'name'        => $this->templateSlice->component_name,
                'type'        => $this->templateSlice->type,
                'label'       => $this->templateSlice->label,
                'placeholder' => ($this->templateSlice->type == 'single' || $this->parent_type == 'repeats') ? false : true,
            ],
            'settings' => $this->settings
        ];

        // Relationships
        if ($this->slices->count())
        {
            $this->slices->map(function ($slice) {
                $slice->parent_type = $this->templateSlice->type;

                return $slice;
            });

            $data['slices'] = SliceInstanceResource::collection($this->slices);
        }

        if ($this->templateSlice->type == 'model')
        {
            $data['slices'] = $this->setModelSlices($this->templateSlice);
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
                'placeholder' => false,
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
