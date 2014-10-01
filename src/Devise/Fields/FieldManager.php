<?php namespace Devise\Fields;

use Carbon\Carbon;
use Field, FieldVersion, DateTime;
use Devise\User\Repositories\UsersRepository;
use Devise\Common\Manager;
use Devise\Fields\Repositories\FieldsRepository;

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
	private $Field, $UsersRepository, $FieldsRepository, $FieldVersion;

	/**
	 * @param Field $Field
	 * @param FieldsRepository $FieldsRepository
	 * @param UsersRepository $UsersRepository
	 */
	public function __construct(Field $Field, FieldVersion $FieldVersion, FieldsRepository $FieldsRepository, UsersRepository $UsersRepository)
	{
		$this->Field     = $Field;
		$this->FieldVersion = $FieldVersion;
		$this->FieldsRepository = $FieldsRepository;
		$this->UsersRepository = $UsersRepository;
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
		$field = $this->FieldsRepository->findFieldByKeyAndPage($input['key'], $input['page_id']);

		// look for a global version of this field
		$field = $field ?: $this->FieldsRepository->findFieldByGlobalKey($input['key']);

		// no field was found so create a new field for this page
        $field = $field ?: $this->createField($input);

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
		$previousVersion = $field->latestPublishedVersion;

		// get the collection_instance_id
		$collection_instance_id = array_get($input, 'collection_instance_id', 0);

        // merge input into the FieldValues for this $field
		$field->value->merge(array_except($input, ['page_id', 'collection_instance_id']));

		// fire updating to any type of field
		$this->fire('devise.field.updating', [$field, $originalInput, $previousVersion]);

		// fire updating to a specific type of field
		$this->fire("devise.{$field->type}.field.updating", [$field, $originalInput, $previousVersion]);

		// create a new version for this field
		$version = $this->createFieldVersion($field->id, $field->value->toJSON(), $collection_instance_id);

		// fire updates to any type of field
		$this->fire('devise.field.updated', [$field, $version, $originalInput, $previousVersion]);

		// fire only updates to a specific type of field
		$this->fire("devise.{$field->type}.field.updated", [$field, $version, $originalInput, $previousVersion]);

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
		$field = $this->FieldsRepository->findFieldById($fieldId);

		// unset the field scope so it doesn't tamper with field version value
		$fieldScope = !isset($input['field_scope']) ? 'page' : $input['field_scope'];
        unset($input['field_scope']);

        //
        // if this is already a page field we cannot change the scope of
        // the field to page, the same goes if the field is global then
        // we cannot change the scope to global b/c that is what it already
        // is set to, so we don't need to do anything further
        //
        if ($fieldScope === $field->scope)
        {
			return $field;
        }

        //
        // change this global field into a page field
        //
        if ($fieldScope == 'page')
        {
	        return $this->findPageSpecificFieldForGlobalField($field, $input['page_id']);
        }

        // this is a field that is specific to a page
        // and we are wanting it to become a global field
        // so we are going to find the global field that
        // shares the same key as this field
        //
        $global = $this->findGlobalFieldForPageSpecificField($field);

        // now we soft delete the page specific field so we
        // don't use it anymore... goodbye page specific field
        $field->delete();

        // let it snow! let it snow! let it snow!
		return $global;
	}

	/**
	 * Gets a page specific field from a global field. If this
	 * field does not exist in the page scope yet, we create it now
	 *
	 * @param  Field $field
	 * @return Field
	 */
	protected function findPageSpecificFieldForGlobalField($field, $pageId)
	{
		$pageField = $this->FieldsRepository->findFieldByKeyAndPage($field->key, $pageId);

		return $pageField ?: $this->createField([
			'page_id' => $pageId,
			'type' => $field->type,
			'human_name' => $field->human_name,
			'key' => $field->key,
			'collection_set_id' => $field->collection_set_id
		]);
	}

	/**
	 * Gets a global field for a page specific field. If this
	 * field does not exist in the global scope yet, we will
	 * create it now.
	 *
	 * @param  Field $field
	 * @return Field
	 */
	protected function findGlobalFieldForPageSpecificField($field)
	{
		$global = $this->FieldsRepository->findFieldByGlobalKey($field->key);

		return $global ?: $this->createField([
			'page_id' => 0,
			'type' => $field->type,
			'human_name' => $field->human_name,
			'key' => $field->key,
			'collection_set_id' => $field->collection_set_id
		]);
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
			'page_id' => 'required',
			'value' => 'required',
		);

		$this->assertValid($input, $rules, "Could not validate input");
	}

	/**
	 * Create field version given input
	 *
	 * @param  integer $fieldId
	 * @param  array $input
	 * @return Version
	 */
	protected function createFieldVersion($fieldId, $value, $collection_instance_id = 0)
	{
		$version = $this->FieldVersion->newInstance();

		$version->field_id = $fieldId;
        $version->responsible_user_id = $this->UsersRepository->retrieveCurrentUserId();

		//
		// stages are todo, staging, pending, review, published
		//
		// todo      - edit values from content manager
		// staging   - edit values and viewing on site as if live
		// pending   - items ready for administrator to review
		// review    - administrators staged area (as if they were live)
		// published - live on the website
		//
		//
        $version->stage = 'published';
        $version->published_at = new DateTime;

        $version->collection_instance_id = $collection_instance_id;
        $version->value = $value;
        $version->save();

        return $version;
	}

	/**
	 * Copy all the active field versions from one page
	 * to another page
	 *
	 * @param  [type] $fromPageId [description]
	 * @param  [type] $toPageId   [description]
	 * @return [type]             [description]
	 */
    public function copyActiveFieldVersions($fromPageId, $toPageId)
    {
        $fields = $this->Field
            ->with('latestPublishedVersion')
            ->where('page_id', '=', $fromPageId)
            ->get();

        foreach ($fields as $field)
        {
            if ($field->latestPublishedVersion !== null)
            {
                $newField = $this->Field->create(array(
                    'collection_set_id' => $field['collection_set_id'],
                    'page_id' => $toPageId,
                    'type' => $field['type'],
                    'human_name' => $field['human_name'],
                    'key' => $field['key']
                ));

                if($field['collection_set_id'] == 0){
                    // not a collection so duplicate published version
                    // version will be duplicated in collection instance manager
                    
                    $newFieldVersion = $this->FieldVersion->create(array(
                        'field_id' => $newField->id,
                        'stage' => 'published',
                        'value' => $field->latestPublishedVersion->value,
                        'published_at' => date('Y-m-d H:i:s', strtotime('now'))
                    ));

                }
            }
        }
    }

    /**
     * Create page field given input
     *
     * @param  array $input
     * @internal param Field $field
     * @return PageField
     */
	protected function createField($input)
	{
		// make sure there isn't a trashed version of this
		// field that we should restore...
		$trashed = $this->FieldsRepository->findTrashedFieldByKeyAndPage($input['key'], $input['page_id']);

		// found some trashed field, so we need to restore it and return it!
		if ($trashed)
		{
			$trashed->restore();
			return $trashed;
		}

		// no trashed version of this field so let's create it in the database
		$field = $this->Field->newInstance();

        $field->page_id = $input['page_id'];
        $field->type = $input['type'];
        $field->human_name = $input['human_name'];
        $field->key = $input['key'];

        if (isset($input['collection_set_id']))
        {
            $field->collection_set_id = $input['collection_set_id'];
        }

		$field->save();

		$version = null;

		if (isset($input['data']))
		{
			$version = $this->createFieldVersion($field->id, $input['data']);
		}

		// notify system that devise field was created
		$this->fire('devise.field.created', [$field, $version, $input]);

		// notify system that a specific type of devise field was created
		$this->fire("devise.{$field->type}.field.created", [$field, $version, $input]);

		return $field;
	}
}