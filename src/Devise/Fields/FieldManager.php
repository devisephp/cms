<?php namespace Devise\Fields;

use Carbon\Carbon;
use Field, GlobalField, DateTime;
use Devise\Common\Manager;
use Devise\Fields\Repositories\FieldsRepository;
use Devise\Languages\Repositories\LanguagesRepository;

/**
 * Class FieldManager
 * @package Devise\Fields
 */
class FieldManager extends Manager
{
	/**
	 * @var Field
	 */
	/**
	 * @var Field|PageField
	 */
	/**
	 * @var UsersRepository|Field|PageField
	 */
	private $Field, $GlobalField, $FieldsRepository, $LanguagesRepository;

	/**
	 * @param Field $Field
	 * @param FieldsRepository $FieldsRepository
	 * @param UsersRepository $UsersRepository
	 */
	public function __construct(Field $Field, GlobalField $GlobalField, FieldsRepository $FieldsRepository, LanguagesRepository $LanguagesRepository)
	{
		$this->Field     = $Field;
		$this->GlobalField = $GlobalField;
		$this->FieldsRepository = $FieldsRepository;
		$this->LanguagesRepository = $LanguagesRepository;
	}

	/**
	 * Find or create field given input
	 *
	 * @param  array $input
	 * @return Field
	 */
	public function findOrCreateField($input)
	{
		$this->validateNewFieldInput($input);

		// look for page specific version of this field
		$field = $this->FieldsRepository->findFieldByKeyAndPageVersion($input['key'], $input['page_version_id'], array_get($input, 'collection_instance_id'));

		// look for a global version of this field
		if (!$field)
		{
			$language = $this->LanguagesRepository->findLanguageForPageVersion($input['page_version_id']);
			$field = $field ?: $this->FieldsRepository->findFieldByGlobalKeyAndLanguage($input['key'], $language->id);
		}

		// no field was found so create a new field for this page
        $field = $field ?: $this->createPageField($input);

        // add extra data to fields... for some reason? Gary?
        $field->index = $input['index'];
        $field->alternateTarget = $input['alternateTarget'];

		return $field;
	}

	/**
	 * Updates the field by creating a new version
	 * of it.
	 *
	 * @param  integer $fieldId
	 * @param  array   $input
	 *
	 * @throws \Devise\Common\ValidationException
	 * @return \Field $errors || $field
	 */
	public function updateField($fieldId, $originalInput)
	{
		// ignores certain input fields (like things that start with an _underscore)
		$input = $this->filterInput($originalInput);

		// get the field we should update
		$field = $this->getFieldToUpdate($fieldId, $input);

		// in case we want to see how things looked before changing anything
		$previousVersion = clone $field->values;

        // merge input into the FieldValues for this $field
		$field->values->merge(array_except($input, ['page_id', 'page_version_id', 'field_scope', 'current_field_scope', 'collection_instance_id']));

		// update this field's json value
		$field->json_value = $field->values->toJSON();

		// save this field in the database
		$field->save();

		// fire updates to any type of field
		$this->fire('devise.field.updated', [$field, $originalInput, $previousVersion]);

		// fire only updates to a specific type of field
		$this->fire("devise.{$field->type}.field.updated", [$field, $originalInput, $previousVersion]);

		// finally!
		return $field;
	}

	/**
	 * This function will do see if $shouldChangeGlobally is set
	 *
	 * @param  integer $fieldId
	 * @param  array $input
	 * @return Field
	 */
	protected function getFieldToUpdate($fieldId, &$input)
	{
		// unset the field scope so it doesn't tamper with field value
		$newFieldScope = !isset($input['field_scope']) ? 'page' : $input['field_scope'];
		$currentFieldScope = !isset($input['current_field_scope']) ? 'page' : $input['current_field_scope'];

		// find field by scope and id
		$field = $this->FieldsRepository->findFieldByIdAndScope($fieldId, $currentFieldScope);

		//
		// if we find field that matches the scope of fieldScope then
		// just return the field because there is nothing else to do
		//
		if ($newFieldScope == $field->scope)
		{
			return $field;
		}

		//
		// change this field scope from global to page
		// find or creates a page field, that overrides the global key
		//
		if ($newFieldScope == 'page')
		{
			return $this->getPageFieldFromGlobalField($field, $input);
		}

		//
		// change this field scope from page to global
		// this removes the page field and creates the
		// global field if it doesn't already exist
		return $this->getGlobalFieldFromPageField($field, $input);
	}

	/**
	 * Changes field scope from global to page
	 * it does this by creating a page field that overrides
	 * the global key
	 *
	 * @param  Field $field
	 * @return PageField
	 */
	public function getPageFieldFromGlobalField($field, $input)
	{
		$pageField = $this->FieldsRepository->findFieldByKeyAndPageVersion($field->key, $input['page_version_id'], null);

		if(!$pageField){
			$pageField = $this->FieldsRepository->findTrashedFieldByKeyAndPageVersion($field->key, $input['page_version_id']);
			if($pageField){
				$pageField->restore();
			}
		}

		return $pageField ?: $this->createPageField([
			'collection_instance_id' => array_get($input, 'collection_instance_id'),
			'page_version_id' => $input['page_version_id'],
			'type' => $field->type,
			'human_name' => $field->human_name,
			'key' => $field->key,
		]);
	}

	/**
	 * Changes field scope from page to global
	 * this removes the page field and creates
	 * or finds the global field
	 *
	 * @param  PageField $pageField
	 * @return GlobalField
	 */
	public function getGlobalFieldFromPageField($pageField, $input)
	{
		$language = $this->LanguagesRepository->findLanguageForPageVersion($input['page_version_id']);

		$global = $this->FieldsRepository->findFieldByGlobalKeyAndLanguage($pageField->key, $language->id);

		$global = $global ?: $this->createGlobalField([
			'language_id' => $language->id,
			'type' => $pageField->type,
			'human_name' => $pageField->human_name,
			'key' => $pageField->key,
		]);

		$pageField->delete();

		return $global;
	}

	/**
	 * This validates the input when creating
	 * a new field
	 *
	 * @param $input
	 * @throws \Devise\Common\ValidationException
	 */
	protected function validateNewFieldInput($input)
	{
		$rules = array(
			'human_name' => 'required',
			'key' => 'required',
			'type' => 'required',
			'settings' => 'required',
			'page_version_id' => 'required',
			'value' => 'required',
		);

		$this->assertValid($input, $rules, "Could not validate input");
	}

    /**
     * Create page field given input
     *
     * @param  array $input
     * @internal param Field $field
     * @return PageField
     */
	protected function createGlobalField($input)
	{
		// make sure there isn't a trashed version of this
		// field that we should restore...
		$trashed = $this->FieldsRepository->findTrashedGlobalFieldByKeyAndLanguage($input['key'], $input['language_id']);

		// found some trashed field, so we need to restore it and return it!
		if ($trashed)
		{
			$trashed->restore();
			return $trashed;
		}

		// no trashed version of this field so let's create it in the database
		$field = $this->GlobalField->newInstance();

        $field->language_id = $input['language_id'];
        $field->type = $input['type'];
        $field->human_name = $input['human_name'];
        $field->key = $input['key'];
        $field->json_value = '{}';
		$field->save();

		// notify system that devise field was created
		$this->fire('devise.field.created', [$field, $input]);

		// notify system that a specific type of devise field was created
		$this->fire("devise.{$field->type}.field.created", [$field, $input]);

		return $field;
	}

    /**
     * Create page field given input
     *
     * @param  array $input
     * @internal param Field $field
     * @return PageField
     */
	protected function createPageField($input)
	{
		// make sure there isn't a trashed version of this
		// field that we should restore...
		$trashed = $this->FieldsRepository->findTrashedFieldByKeyAndPageVersion($input['key'], $input['page_version_id']);

		// found some trashed field, so we need to restore it and return it!
		if ($trashed)
		{
			$trashed->restore();
			return $trashed;
		}

		// no trashed version of this field so let's create it in the database
		$field = $this->Field->newInstance();

        $field->page_version_id = $input['page_version_id'];
        $field->type = $input['type'];
        $field->human_name = $input['human_name'];
        $field->key = $input['key'];
        $field->collection_instance_id = array_get($input, 'collection_instance_id');
        $field->json_value = '{}';
		$field->save();

		// notify system that devise field was created
		$this->fire('devise.field.created', [$field, $input]);

		// notify system that a specific type of devise field was created
		$this->fire("devise.{$field->type}.field.created", [$field, $input]);

		return $field;
	}
}