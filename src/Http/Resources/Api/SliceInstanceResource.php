<?php

namespace Devise\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class SliceInstanceResource extends JsonResource
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
            'id'       => $this->id,
            'name'     => $this->component_name
        ];

        if ($this->fields->count())
        {
            $data['fields'] = [];
            foreach ($this->fields as $field)
            {
                $data['fields'][$field->key] = new FieldResource($field);
            }
        }

        return $data;
    }
}