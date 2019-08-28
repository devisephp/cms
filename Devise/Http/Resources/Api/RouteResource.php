<?php

namespace Devise\Http\Resources\Api;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Route;

class RouteResource extends Resource
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
            'id'         => $this->id,
            'title'      => $this->title,
            'route_name' => $this->route_name,
            'url'        => $this->getUrl()
        ];
    }

    public function getUrl()
    {
        if (strpos($this->slug, '{') === false && Route::has($this->route_name))
        {
            return route($this->route_name);

        }

        return null;
    }
}