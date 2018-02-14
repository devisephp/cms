<?php namespace Devise\Pages\Fields;

use Devise\Models\DvsField;
use Devise\Support\Framework;

/**
 * A field manager has the responsibilty of managing fields in
 * the database.
 */
class FieldManager
{
  /**
   * DvsField model
   *
   * @var DvsField
   */
  private $DvsField;

  /**
   * FieldsRepository lets us fetch fields from database
   *
   * @var FieldsRepository
   */
  private $FieldsRepository;

  /**
   * Construct a new Field Manager
   *
   * @param DvsField $DvsField
   * @param FieldsRepository $FieldsRepository
   * @param Framework $Framework
   */
  public function __construct(DvsField $DvsField, FieldsRepository $FieldsRepository, Framework $Framework)
  {
    $this->DvsField = $DvsField;
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

    $newValues = array_get($fieldInput, 'values', []);

    $field->values->override($newValues);

    $field->content_requested = array_get($fieldInput, 'content_requested', false) == 1;

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
   * @param $slices
   */
  public function saveSliceInstanceFields($slices)
  {
    foreach ($slices as $slice)
    {
      foreach ($slice['fields'] as $fieldKey => $fieldValue)
      {
        $field = $this->DvsField
          ->firstOrNew(['slice_instance_id' => $slice['instance_id'], 'key' => $fieldKey]);

        $field->slice_instance_id = $slice['instance_id'];
        $field->key = $fieldKey;
        $field->json_value = json_encode($fieldValue);
        $field->save();
      }

      if (isset($slice['slices']) && $slice['slices'])
      {
        $this->saveSliceInstanceFields($slice['slices']);
      }
    }
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
    $scope = array_get($fieldInput, 'scope');

    $newScope = array_get($fieldInput, 'new_scope', $scope);

    $field = $scope == 'global'
      ? $this->GlobalField->whereId($fieldId)->firstOrFail()
      : $this->DvsField->whereId($fieldId)->firstOrFail();

    if ($newScope !== $scope)
    {
      $field = $this->changeFieldScope($field, $newScope, $fieldInput, $pageInput);
    }

    return $field;
  }

  /**
   * Changes the field scope
   *
   * @param  DvsField|DvsGlobalField $field
   * @param  string $newScope
   * @param  array $input
   * @return DvsField|DvsGlobalField
   */
  protected function changeFieldScope($field, $newScope, $fieldInput, $pageInput)
  {
    if ($newScope == 'global')
    {
      $field->delete(); // delete the page field so the global field can take over

      return $this->changeToGlobalField($fieldInput, $pageInput);
    }

    return $this->changeToPageField($fieldInput, $pageInput);
  }

  /**
   * Changes this page field to a global field
   *
   * @param  array $fieldInput
   * @param  array $pageInput
   * @return DvsGlobalField
   */
  protected function changeToGlobalField($fieldInput, $pageInput)
  {
    $field = $this->FieldsRepository->findFieldByGlobalKeyAndLanguage($fieldInput['key'], $pageInput['language_id']);

    if (!$field)
    {
      $field = $this->newGlobalField($pageInput['language_id'], $fieldInput['key'], $fieldInput['type'], $fieldInput['human_name']);
      $this->removePristinePageFields($fieldInput['key']);
    }

    return $field;
  }

  /**
   * Removes the pristine page fields
   * for this global field. We only
   * do this when we *first* create
   * the global field
   *
   * @param  DvsGlobalField $global
   * @return void
   */
  protected function removePristinePageFields($key)
  {
    $pristine = $this->FieldsRepository->findPristinePageFields($key);

    foreach ($pristine as $field)
    {
      $field->delete();
    }
  }

  /**
   * Changes this global field to a page field
   *
   * @param  array $fieldInput
   * @param  array $pageInput
   * @return DvsField
   */
  protected function changeToPageField($fieldInput, $pageInput)
  {
    $field = $this->FieldsRepository->findTrashedFieldByKeyAndPageVersion($fieldInput['key'], $pageInput['page_version_id']);

    if ($field)
    {
      $field->restore();

      return $field;
    }

    $field = $this->FieldsRepository->findFieldByKeyAndPageVersion($fieldInput['key'], $pageInput['page_version_id'], null);

    return $field ?: $this->newPageField($pageInput['page_version_id'], $fieldInput['key'], $fieldInput['type'], $fieldInput['human_name']);
  }

  /**
   * Create page field given input
   *
   * @param  array $input
   * @internal param Field $field
   * @return PageField
   */
  protected function newGlobalField($languageId, $key, $type, $humanName)
  {
    $field = $this->GlobalField->newInstance();

    $field->language_id = $languageId;
    $field->type = $type;
    $field->human_name = $humanName;
    $field->key = $key;
    $field->json_value = '{}';
    $field->save();

    return $field;
  }

  /**
   * Create page field given input
   *
   * @param  array $input
   * @internal param Field $field
   * @return PageField
   */
  protected function newPageField($pageVersionId, $key, $type, $humanName)
  {
    $field = $this->DvsField->newInstance();

    $field->page_version_id = $pageVersionId;
    $field->type = $type;
    $field->human_name = $humanName;
    $field->key = $key;
    $field->collection_instance_id = null;
    $field->json_value = '{}';
    $field->save();

    return $field;
  }
}