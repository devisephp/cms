<?php

namespace Devise\Resources\Vue;

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
    $scheme =  (request()->serure) ? 'https' : 'http';
    return [
      'name'   => $this->name,
      'current'   => $this->current,
      'url' => $scheme . '://' . $this->domain,
      'languages' => LanguageResource::collection($this->languages)
    ];
  }
}