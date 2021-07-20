<?php

namespace Devise\Http\Resources\Vue;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'id'      => $this->id,
            'name'    => $this->name,
            'layout'  => $this->layout,
            'is_live' => ($this->page->liveVersion) ? ($this->page->liveVersion->id == $this->id) : false,
            'current' => ($this->page->currentVersion) ? ($this->page->currentVersion->id == $this->id) : false
        ];
    }
}