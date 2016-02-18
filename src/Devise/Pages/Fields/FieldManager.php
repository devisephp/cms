<?php namespace Devise\Pages\Fields;

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
	private $Field;

	/**
	 * DvsGlobalField model
	 *
	 * @var DvsGlobalField
	 */
	private $GlobalField;

	/**
	 * FieldsRepository lets us fetch fields from database
	 *
	 * @var FieldsRepository
	 */
	private $FieldsRepository;

	/**
	 * Construct a new Field Manager
	 *
	 * @param \DvsField           $Field
	 * @param \DvsGlobalField     $GlobalField
	 * @param FieldsRepository    $FieldsRepository
     * @param Framework           $Framework
	 */
	public function __construct(\DvsField $Field, \DvsGlobalField $GlobalField, FieldsRepository $FieldsRepository, Framework $Framework)
	{
		$this->Field     = $Field;
		$this->GlobalField = $GlobalField;
		$this->FieldsRepository = $FieldsRepository;
        $this->Event = $Framework->Event;
    }

	/**
	 * Updates the field
	 *
	 * @param  integer $fieldId
	 * @param  array   $input
	 * @return \DvsField | \DvsGlobaField
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
		$field = $scope === 'global' ? $this->GlobalField->findOrFail($fieldId) : $this->Field->findOrFail($fieldId);

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
		return $this->Field->whereIn('id', $fieldIds)->update(['content_requested' => false]);
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
			: $this->Field->whereId($fieldId)->firstOrFail();

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
	 * @param  string                  $newScope
	 * @param  array                   $input
	 * @return DvsField|DvsGlobalField
	 */
	protected function changeFieldScope($field, $newScope, $fieldInput, $pageInput)
	{
		if ($newScope == 'global')
		{
			return $this->changeToGlobalField($fieldInput, $pageInput);
		}

		return $this->changeToPageField($fieldInput, $pageInput);
	}

	/**
	 * Changes this page field to a global field
	 *
	 * @param  array    $fieldInput
	 * @param  array    $pageInput
	 * @return DvsGlobalField
	 */
	protected function changeToGlobalField($fieldInput, $pageInput)
	{
		$field = $this->FieldsRepository->findFieldByGlobalKeyAndLanguage($fieldInput['key'], $pageInput['language_id']);

		// try to restore a deleted global field if we can't find it normally
		// it may have been soft deleted at some point
		if (!$field)
		{
			$field = $this->FieldsRepository->findTrashedFieldByGlobalKeyAndLanguage($fieldInput['key'], $pageInput['language_id']);

			if ($field) $field->restore();
		}

		if (!$field)
		{
			$field = $this->newGlobalField($pageInput['language_id'], $fieldInput['key'], $fieldInput['type'], $fieldInput['human_name']);

			// we are not going to delete any page fields now
			// global fields will allways override page fields now
			// it used to be the other way around
			// $this->removePristinePageFields($fieldInput['key']);
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
	 * @param  array           $fieldInput
	 * @param  array           $pageInput
	 * @return DvsField
	 */
	protected function changeToPageField($fieldInput, $pageInput)
	{
		// we remove global fields now when converting back to page fields
		$global = $this->FieldsRepository->findFieldByGlobalKeyAndLanguage($fieldInput['key'], $pageInput['language_id']);

		if ($global)
		{
			$global->delete();
		}

		// probably don't need this logic anymore since we don't remove page fields
		// but we will keep it for backwards compatibility purposes
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
		$field = $this->Field->newInstance();

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