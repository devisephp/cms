<?php

namespace Devise\Http\Resources\Vue;

use Devise\Support\Framework;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Route;

class FieldResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return $this->value;
    }
}