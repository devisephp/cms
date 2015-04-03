<?php namespace Devise\Pages\Fields;

use Devise\Languages\LanguagesRepository;
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
	 * LanguagesRepository ensures we use the correct
	 * language for certain fields (english, spanish, etc)
	 *
	 * @var LanguagesRepository
	 */
	private $LanguagesRepository;

	/**
	 * Construct a new Field Manager
	 *
	 * @param \DvsField           $Field
	 * @param \DvsGlobalField     $GlobalField
	 * @param FieldsRepository    $FieldsRepository
	 * @param LanguagesRepository $LanguagesRepository
     * @param Framework           $Framework
	 */
	public function __construct(\DvsField $Field, \DvsGlobalField $GlobalField, FieldsRepository $FieldsRepository, LanguagesRepository $LanguagesRepository, Framework $Framework)
	{
		$this->Field     = $Field;
		$this->GlobalField = $GlobalField;
		$this->FieldsRepository = $FieldsRepository;
		$this->LanguagesRepository = $LanguagesRepository;
        $this->Validator = $Framework->Validator;
        $this->Event = $Framework->Event;
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
			$field = $this->FieldsRepository->findFieldByGlobalKeyAndLanguage($input['key'], $language->id);
		}

		// no field was found so create a new field for this page
        $field = $field ?: $this->createPageField($input);

        // we want to be able to override the type and human name if
        // the developer changes it in the blade view later on down the road
        $type = array_get($input, 'type');
        $humanName = array_get($input, 'human_name');

        if ($type && $type != $field->type)
        {
	        $field->type = $type;
	        $field->save();
        }

        // human names can be updated too in the database...
        // whenever the developer changes it in the blade view
        if ($humanName && $humanName != $field->human_name)
        {
	        $field->human_name = $humanName;
	        $field->save();
        }

        // we apply these fields dynamically for helpers
        $field->index = array_get($input, 'index', '');
        $field->alternateTarget = array_get($input, 'alternateTarget', '');

		return $field;
	}

	/**
	 * Updates the field
	 *
	 * @param  integer $fieldId
	 * @param  array   $originalInput
	 * @return \Field $errors || $field
	 * @throws \Devise\Support\DeviseValidationException
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
		$field->values->merge(array_except($input, ['page_id', 'page_version_id', 'field_scope', 'current_field_scope', 'collection_instance_id', 'content_requested']));

        // set "content_requested" value
        $field->content_requested = array_get($input, 'content_requested', false);

		// update this field's json value
		$field->json_value = array_get($originalInput, '_reset_values', false) ? '{}' : $field->values->toJSON();

		// save this field in the database
		$field->save();

		// fire updates to any type of field
		$this->Event->fire('devise.field.updated', [$field, $originalInput, $previousVersion]);

		// fire only updates to a specific type of field
		$this->Event->fire("devise.{$field->type}.field.updated", [$field, $originalInput, $previousVersion]);

		// finally!
		return $field;
	}

	/**
	 * Sets a series of fields content requested to false
	 * @param  array $fieldIds Array of field ids
	 * @return bool
	 */
	public function markNoContentRequested($fieldIds) {
		return $this->Field->whereIn('id', $fieldIds)->update(['content_requested' => 0]);
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
	protected function getPageFieldFromGlobalField($field, $input)
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
	protected function getGlobalFieldFromPageField($pageField, $input)
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
	 * @throws \Devise\Support\DeviseValidationException
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

        $validator = $this->Validator->make($input, $rules);

        if ($validator->fails())
        {
            throw new \Devise\Support\DeviseValidationException('Input given is invalid', $validator->errors());
        }
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
		$this->Event->fire('devise.field.created', [$field, $input]);

		// notify system that a specific type of devise field was created
		$this->Event->fire("devise.{$field->type}.field.created", [$field, $input]);

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
		$this->Event->fire('devise.field.created', [$field, $input]);

		// notify system that a specific type of devise field was created
		$this->Event->fire("devise.{$field->type}.field.created", [$field, $input]);

		return $field;
	}

    /**
     * Filters out the underscores from the input
     *
     * @param  array $input
     * @return array
     */
    protected function filterInput($input)
    {
        $removeKeys = array_filter(array_keys($input), function($key){ return strpos($key, '_') === 0; });

        foreach ($removeKeys as $removeKey)
        {
            unset($input[$removeKey]);
        }

        return $input;
    }
}