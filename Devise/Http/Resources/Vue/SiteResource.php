<?php

namespace Devise\Http\Resources\Vue;

use Illuminate\Http\Resources\Json\Resource;

class SiteResource extends Resource
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
            'id'        => $this->id,
            'name'      => $this->name,
            'current'   => $this->current,
            'url'       => $this->url,
            'data'      => $this->data,
            'domain'    => $this->domain,
            'settings'  => $this->settings,
            'languages' => LanguageResource::collection($this->whenLoaded('languages'))
        ];
    }
}