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
            'versions'           => PageVersionResource::collection($this->versions),
            'meta'               => MetaResource::collection($this->metas),
            'site'               => new SiteResource($this->site),
            'slices'             => [],
            'language'           => new LanguageResource($this->language),
            'languages'          => []
        ];


        if ($this->translatedFromPage)
        {
            $this->setLanguages($data, $this->translatedFromPage, $this->translatedFromPage->localizedPages);
        } else
        {
            $this->setLanguages($data, $this, $this->localizedPages);
        }

        // Relationships
        if ($this->currentVersion && $this->currentVersion->slices->count())
        {
            $data['slices'] = SliceInstanceResource::collection($this->currentVersion->slices);
        }

        return $data;
    }

    private function setLanguages(&$data, $page, $localizedPages)
    {
        $data['languages'][] = [
            'name'    => $page->language->name,
            'url'     => $page->slug,
            'current' => ($page->id == $this->id)
        ];

        foreach ($localizedPages as $page)
        {
            $data['languages'][] = [
                'name'    => $page->language->name,
                'url'     => $page->slug,
                'current' => ($page->id == $this->id)
            ];
        }
    }
}