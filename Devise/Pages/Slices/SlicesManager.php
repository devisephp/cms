<?php

namespace Devise\Pages\Slices;

use Devise\Models\DvsField;
use Devise\Models\DvsSliceInstance;

class SlicesManager
{
  private $DvsSliceInstance;
  private $DvsField;


  /**
   * SlicesManager constructor.
   * @param DvsSliceInstance $DvsSliceInstance
   * @param DvsField $DvsField
   */
  public function __construct(DvsSliceInstance $DvsSliceInstance, DvsField $DvsField)
  {
    $this->DvsSliceInstance = $DvsSliceInstance;
    $this->DvsField = $DvsField;
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
      'slice_id'           => $instance->slice_id,
      'label'              => $instance->label
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

    foreach ($instance->slices as $slice){
      $this->copySlice($slice, $pageVersionId, $newSlice->id);
    }
  }
}