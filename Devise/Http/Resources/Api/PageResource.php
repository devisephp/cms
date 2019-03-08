<?php

namespace Devise\Http\Resources\Api;

use Devise\Http\Resources\Vue\SliceInstanceResource;

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
            'title'              => $this->title,
            'slug'               => $this->slug,
            'meta_title'         => $this->meta_title,
            'canonical'          => $this->canonical,
            'ab_testing_enabled' => $this->ab_testing_enabled,
            'is_live'            => ($this->liveVersion) ? true : false,
            'head'               => $this->head,
            'footer'             => $this->footer,
            'middleware'         => $this->middleware,

            // Relationships
            'versions'           => PageVersionResource::collection($this->whenLoaded('versions')),
            'meta'               => MetaResource::collection($this->whenLoaded('metas')),

            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s')
        ];

        // Relationships
        if ($this->currentVersion && $this->currentVersion->slices->count())
        {
            $data['slices'] = SliceInstanceResource::collection($this->currentVersion->slices);
        }

        return $data;
    }
}