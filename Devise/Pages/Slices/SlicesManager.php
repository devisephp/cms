<?php

namespace Devise\Pages\Slices;

use Devise\Models\DvsField;
use Devise\Models\DvsPageVersion;
use Devise\Models\DvsSliceInstance;
use Devise\Models\DvsTemplate;
use Devise\Models\DvsTemplateSlice;

class SlicesManager
{
  private $DvsSliceInstance;

  private $DvsTemplateSlice;

  private $DvsField;

  private $DvsPageVersion;


  /**
   * SlicesManager constructor.
   * @param DvsSliceInstance $DvsSliceInstance
   * @param DvsField $DvsField
   */
  public function __construct(DvsSliceInstance $DvsSliceInstance, DvsTemplateSlice $DvsTemplateSlice, DvsField $DvsField, DvsPageVersion $DvsPageVersion)
  {
    $this->DvsSliceInstance = $DvsSliceInstance;
    $this->DvsTemplateSlice = $DvsTemplateSlice;
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

  /**
   * @param $templateId
   * @param $slices
   * @param int $parentId
   * @param int $index
   */
  public function saveAllSlices($templateId, $slices, $parentId = 0, $index = 0)
  {
    $pageVersionIds = $this->DvsPageVersion
      ->where('template_id', $templateId)
      ->pluck('id');

    $this->iterateSlices($templateId, $slices, $parentId, $index, $pageVersionIds);
  }

  /**
   * @param $templateId
   * @param $slices
   * @param int $parentId
   * @param int $index
   * @param array $pageVersionIds
   */
  public function iterateSlices($templateId, $slices, $parentId = 0, $index = 0, $pageVersionIds = [])
  {
    foreach ($slices as $slice)
    {
      $templateSlice = $this->DvsTemplateSlice
        ->firstOrNew(['id' => $slice["id"]]);

      $templateSlice->template_id = $templateId;
      $templateSlice->parent_id = $parentId;
      $templateSlice->slice_id = $slice["slice_id"];
      $templateSlice->type = $slice["type"];
      $templateSlice->label = $slice["label"];
      $templateSlice->position = $index;
      $templateSlice->model = $slice["model"] ?: "";
      $templateSlice->model_query = $slice["model_query"] ?: "";
      $templateSlice->config = $slice["config"] ?: "";
      $templateSlice->save();

      if ($templateSlice->type == 'single' || $templateSlice->type == 'model')
      {
        foreach ($pageVersionIds as $pageVersionId)
        {
          $instance = $this->DvsSliceInstance
            ->firstOrNew(['page_version_id' => $pageVersionId, 'template_slice_id' => $templateSlice->id]);

          $instance->page_version_id = $pageVersionId;
          $instance->parent_instance_id = ($templateSlice->parent_id) ? $this->getParentInstanceId($pageVersionId, $templateSlice->parent_id) : 0;
          $instance->template_slice_id = $templateSlice->id;
          $instance->enabled = $slice['enabled'];
          $instance->position = $index;
          $instance->save();
        }
      }

      $index++;
      if (isset($slice->slices))
      {
        $this->saveAllSlices($templateId, $slice->slices, $templateSlice->id, $index);
      }
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

    foreach ($instance->slices as $slice)
    {
      $this->copySlice($slice, $pageVersionId, $newSlice->id);
    }
  }

  /**
   * @param $pageVersionId
   * @param $parentTemplateSliceId
   * @return mixed
   */
  private function getParentInstanceId($pageVersionId, $parentTemplateSliceId)
  {
    $parent = $this->DvsSliceInstance
      ->where('page_version_id', $pageVersionId)
      ->where('template_slide_id', $parentTemplateSliceId)
      ->first();

    return $parent->id;
  }
}