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
      'site_id'            => $this->site_id,
      'title'              => $this->title,
      'slug'               => $this->slug,
      'canonical'          => $this->canonical,
      'ab_testing_enabled' => $this->ab_testing_enabled,
      'data'               => $this->data,
      'versions'           => PageVersionResource::collection($this->versions),
      'meta'               => MetaResource::collection($this->metas),
      'site'               => new SiteResource($this->site),
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

    foreach ($localizedPages as $page)
    {
      $data['languages'][] = [
        'name'    => $page->language->human_name,
        'url'     => $page->slug,
        'current' => ($page->translatedFromPage->id == $this->id)
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