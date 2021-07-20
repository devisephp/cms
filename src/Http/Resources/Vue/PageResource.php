<?php

namespace Devise\Http\Resources\Vue;

use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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
            'meta_title'         => $this->meta_title,
            'canonical'          => $this->canonical,
            'ab_testing_enabled' => $this->ab_testing_enabled,
            'versions'           => PageVersionResource::collection($this->versions),
            'meta'               => MetaResource::collection($this->metas),
            'site'               => new SiteResource($this->site),
            'slices'             => [],
            'live_version_id'    => $this->liveVersion->id,
            'current_version_id' => $this->currentVersion->id,
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
        if ($this->currentVersion)
        {
            if ($this->currentVersion->slices->count())
            {
                $data['slices'] = SliceInstanceResource::collection($this->currentVersion->slices);
            }

            $data['settings'] = $this->currentVersion->settings;

            $data['version_last_updated_at'] = $this->currentVersion->updated_at->format('Y-m-d H:i:s');
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