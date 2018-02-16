<?php

namespace Devise\Http\Resources\Vue;

use Illuminate\Http\Resources\Json\Resource;

class PageResource extends Resource
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
      'id'                 => $this->id,
      'title'              => $this->meta_title,
      'slug'               => $this->slug,
      'canonical'          => $this->canonical,
      'ab_testing_enabled' => $this->ab_testing_enabled,
      'versions'           => PageVersionResource::collection($this->versions),
      'slices'             => [],
      'languages'          => []
    ];


    if ($this->translatedFromPage)
    {
      $data['languages'][] = [
        'name'    => $this->translatedFromPage->language->human_name,
        'url'     => $this->translatedFromPage->slug,
        'current' => ($this->translatedFromPage->id == $this->id)
      ];

      $localizedPages = $this->translatedFromPage->localizedPages;
    } else
    {
      $localizedPages = $this->localizedPages;
    }

    foreach ($localizedPages as $language)
    {
      $data['languages'][] = [
        'name'    => $language->language->human_name,
        'url'     => $language->slug,
        'current' => ($this->translatedFromPage->id == $this->id)
      ];
    }

    // Relationships
    if ($this->currentVersion && $this->currentVersion->template)
    {
      $data['slices'] = SliceInstanceResource::collection($this->currentVersion->slices);
    }

    return $data;
  }
}