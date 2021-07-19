<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;
use Devise\Http\Requests\Meta\SaveMeta;
use Devise\Http\Requests\Slices\SaveSlice;
use Devise\Models\DvsField;
use Devise\Models\DvsSliceInstance;

use Illuminate\Routing\Controller;

class PageVersionsSlicesController extends Controller
{
    protected $DvsSliceInstance;

    protected $DvsField;

    /**
     *
     */
    public function __construct(DvsSliceInstance $DvsSliceInstance, DvsField $DvsField)
    {
        $this->DvsSliceInstance = $DvsSliceInstance;
        $this->DvsField = $DvsField;
    }

    /**
     *
     */
    public function store(SaveSlice $request, $pageVersionId)
    {
        $instance = $this->DvsSliceInstance
            ->findOrFail($request->get('copy_slice_id'));

        $instance->parent_instance_id = 0;
        $this->copySlice($instance, $pageVersionId);
    }

    /**
     *
     */
    private function copySlice($instance, $pageVersionId, $parentSliceId = 0)
    {
        $newSlice = $this->DvsSliceInstance
            ->create([
                'page_version_id'    => $pageVersionId,
                'parent_instance_id' => $parentSliceId,
                'view'               => $instance->view,
                'label'              => $instance->label,
                'position'           => $instance->position,
                'settings'           => $instance->settings,
                'model_query'        => $instance->model_query,
            ]);

        foreach ($instance->fields as $field)
        {
            $this->DvsField
                ->create([
                    "slice_instance_id" => $newSlice->id,
                    "key"               => $field->key,
                    "json_value"        => $field->json_value,
                    "content_requested" => $field->content_requested
                ]);
        }

        foreach ($instance->slices as $slice)
        {
            $this->copySlice($slice, $pageVersionId, $newSlice->id);
        }
    }
}