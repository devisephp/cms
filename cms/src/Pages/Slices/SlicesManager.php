<?php

namespace Devise\Pages\Slices;

use Devise\Models\DvsField;
use Devise\Models\DvsPageVersion;
use Devise\Models\DvsSliceInstance;
use Devise\Devise;

use Illuminate\Support\Facades\File;

class SlicesManager
{
    private $DvsSliceInstance;

    private $DvsField;

    private $DvsPageVersion;


    /**
     * SlicesManager constructor.
     * @param DvsSliceInstance $DvsSliceInstance
     * @param DvsField $DvsField
     */
    public function __construct(DvsSliceInstance $DvsSliceInstance, DvsField $DvsField, DvsPageVersion $DvsPageVersion)
    {
        $this->DvsSliceInstance = $DvsSliceInstance;
        $this->DvsField = $DvsField;
        $this->DvsPageVersion = $DvsPageVersion;
    }

    /**
     * Copies all the fields from one page version into another page version
     *
     * @param $oldVersion
     * @param $newVersion
     * @return void
     */
    public function copySlicesAndFieldsFromVersionToVersion($oldVersion, $newVersion)
    {
        foreach ($oldVersion->slices as $sliceInstance)
        {
            $this->copySlice($sliceInstance, $newVersion->id);
        }
    }

    public function copySlicesForNewPageVersion($slices, $pageVersionId, $parentId = 0)
    {
        foreach ($slices as $slice)
        {
            $instance = new DvsSliceInstance();

            $instance->page_version_id = $pageVersionId;
            $instance->parent_instance_id = $parentId;
            $instance->view = $slice->view;
            $instance->label = $slice->label;
            $instance->position = $slice->position;
            $instance->settings = $slice->settings;
            $instance->model_query = $slice->model_query;
            $instance->save();

            $this->copySlicesForNewPageVersion($slice->slices, $pageVersionId, $instance->id);
        }
    }

    /**
     * @param $instance
     * @param $pageVersionId
     * @param int $parentSliceId
     * @internal param int $parentId
     */
    private function copySlice($instance, $pageVersionId, $parentSliceId = 0)
    {
        $newSlice = $this->DvsSliceInstance->create([
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
            $this->DvsField->create([
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

    public function registerAllComponents()
    {
        $files = collect(File::allFiles(resource_path('views/slices')));

        $files = $files->mapInto(Component::class);

        foreach ($files as $file)
        {
            Devise::addComponent($file);
        }
    }
}