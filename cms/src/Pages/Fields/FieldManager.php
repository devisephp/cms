<?php namespace Devise\Pages\Fields;

use Devise\Models\DvsField;
use Devise\Models\DvsSliceInstance;
use Devise\Support\Framework;
use Illuminate\Support\Arr;

/**
 * A field manager has the responsibilty of managing fields in
 * the database.
 */
class FieldManager
{
    private $DvsField;

    private $DvsSliceInstance;

    private $FieldsRepository;

    private $Event;

    /**
     * Construct a new Field Manager
     *
     * @param DvsField $DvsField
     * @param DvsSliceInstance $DvsSliceInstance
     * @param FieldsRepository $FieldsRepository
     * @param Framework $Framework
     */
    public function __construct(DvsField $DvsField, DvsSliceInstance $DvsSliceInstance, FieldsRepository $FieldsRepository, Framework $Framework)
    {
        $this->DvsField = $DvsField;
        $this->DvsSliceInstance = $DvsSliceInstance;
        $this->FieldsRepository = $FieldsRepository;
        $this->Event = $Framework->Event;
    }

    /**
     * Updates the field
     *
     * @param  integer $fieldId
     * @param  array $input
     * @return DvsField
     */
    public function updateField($fieldId, $input)
    {
        $fieldInput = $input['field'];

        $pageInput = $input['page'];

        $field = $this->getFieldToUpdate($fieldId, $fieldInput, $pageInput);

        $oldValues = clone $field->values;

        $newValues = Arr::get($fieldInput, 'values', []);

        $field->values->override($newValues);

        $field->content_requested = Arr::get($fieldInput, 'content_requested', false) == 1;

        $field->json_value = $field->values->toJSON();

        $field->save();

        $this->Event->fire('devise.field.updated', [$field, $newValues, $oldValues]);

        $this->Event->fire("devise.{$field->type}.field.updated", [$field, $newValues, $oldValues]);

        return $field;
    }

    /**
     * Reset field values
     *
     * @param  integer $fieldId
     * @return \DvsField | \DvsGlobalField
     */
    public function resetField($fieldId, $scope)
    {
        $field = $scope === 'global' ? $this->GlobalField->findOrFail($fieldId) : $this->DvsField->findOrFail($fieldId);

        $field->json_value = '{}';

        $field->values->override([]);

        $field->save();

        return $field;
    }

    /**
     * Sets a series of fields content requested to false
     * @param  array $fieldIds Array of field ids
     * @return bool
     */
    public function markNoContentRequested($fieldIds)
    {
        return $this->DvsField->whereIn('id', $fieldIds)->update(['content_requested' => false]);
    }

    /**
     * This function will get us our field
     *
     * @param  integer $fieldId
     * @param  array $input
     * @return Field
     */
    protected function getFieldToUpdate($fieldId, $fieldInput, $pageInput)
    {
        $scope = Arr::get($fieldInput, 'scope');

        $field = $scope == 'global'
            ? $this->GlobalField->whereId($fieldId)->firstOrFail()
            : $this->DvsField->whereId($fieldId)->firstOrFail();

        return $field;
    }


    /**
     * @param $slices
     */
    public function saveSliceInstanceFields($pageVersionId, $slices)
    {
        $instanceIds = [];
        $index = 0;

        $this->iterateSliceInstances($pageVersionId, $slices, 0, $index, $instanceIds);

        $this->deleteOldSlicesAndFields($pageVersionId, $instanceIds);
    }

    private function iterateSliceInstances($pageVersionId, $slices, $parentId = 0, &$index = 0, &$instanceIds = [])
    {
        foreach ($slices as $slice)
        {
            $sliceInstanceId = $slice['metadata']['instance_id'];

            $sliceInstance = $this->DvsSliceInstance->firstOrNew(['id' => $sliceInstanceId]);
            $sliceInstance->page_version_id = $pageVersionId;
            $sliceInstance->parent_instance_id = $parentId;
            $sliceInstance->settings = (isset($slice['settings'])) ? $slice['settings'] : null;
            $sliceInstance->position = $index;
            $sliceInstance->view = $slice['metadata']['view'];
            $sliceInstance->label = $slice['metadata']['label'];
            $sliceInstance->model_query = $slice['metadata']['model_query'];
            $sliceInstance->save();

            $sliceInstanceId = $sliceInstance->id;
            $instanceIds[] = $sliceInstanceId;

            foreach ($slice as $fieldKey => $fieldValue)
            {
                if ($fieldKey != 'metadata' && $fieldKey != 'slices' && $fieldKey != 'settings')
                {
                    $field = $this->DvsField
                        ->firstOrNew(['slice_instance_id' => $sliceInstanceId, 'key' => $fieldKey]);

                    $field->slice_instance_id = $sliceInstanceId;
                    $field->key = $fieldKey;
                    $field->json_value = json_encode($fieldValue);
                    $field->save();
                }
            }

            $index++;

            if ($slice['metadata']['type'] != 'model' && isset($slice['slices']) && $slice['slices'])
            {
                $this->iterateSliceInstances($pageVersionId, $slice['slices'], $sliceInstanceId, $index, $instanceIds);
            }
        }
    }

    private function deleteOldSlicesAndFields($pageVersionId, $ignoreIds = [])
    {
        $slices = $this->DvsSliceInstance
            ->whereNotIn('id', $ignoreIds)
            ->where('page_version_id', $pageVersionId)
            ->get();

        foreach ($slices as $slice)
        {
            $slice->fields()->delete();
            $slice->delete();
        }
    }
}