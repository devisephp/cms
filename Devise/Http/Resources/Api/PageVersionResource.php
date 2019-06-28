<?php

namespace Devise\Http\Resources\Api;

use Illuminate\Http\Resources\Json\Resource;

class PageVersionResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'layout'            => $this->layout,
            'starts_at'         => $this->starts_at,
            'ends_at'           => $this->ends_at,
            'ab_testing_amount' => $this->ab_testing_amount,
            'is_live'           => ($this->page->currentVersion) ? ($this->page->currentVersion->id == $this->id) : false,

            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
        ];
    }
}