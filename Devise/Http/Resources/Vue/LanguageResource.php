<?php

namespace Devise\Http\Resources\Vue;

use Devise\Sites\SiteDetector;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\App;

class LanguageResource extends Resource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $detector = App::make(SiteDetector::class);
        $site = $detector->current();

        // dd($this);

        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'default' => $this->pivot_default,
            'path'    => ($this->pivot_default) ? '/' : '/' . $this->code,
            'url'     => ($this->pivot_default) ? $site->url . '/' : $site->url . '/' . $this->code,
        ];
    }
}