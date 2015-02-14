<?php namespace Devise\Sidebar;

use Devise\Support\Framework;

/**
 * The model mapper's goal is to look through the config file
 * model-mapping.php and then take the picks, rules, messages
 * and types and put them into a object that we can use elsewhere.
 *
 * It can also updates a model using the mapping config file.
 */
class ModelMapper
{
	/**
	 * Creates the new model mapper factory
	 *
	 * @param \DvsModelField  $DvsModelField
	 * @param Framework       $Framework
	 */
	public function __construct(\DvsModelField $DvsModelField, Framework $Framework, \DvsPageVersion $PageVersion)
	{
		$this->DvsModelField = $DvsModelField;
		$this->Config = $Framework->Config;
		$this->App = $Framework->Container;
		$this->Event = $Framework->Event;
		$this->Validator = $Framework->Validator;
		$this->Schema = $Framework->Schema;
		$this->PageVersion = $PageVersion;
		$this->config = null;
	}

	/**
	 * Get the model mapping with a real model
	 * key and class name
	 *
	 * @param  string  $className
	 * @param  integer $key
	 * @return ModelMap
	 */
	public function lookupWithKey($className, $key)
	{
		$mapping = $this->mapping($className);

		// object for the model mapping
		$map = new \StdClass;
		$map->model = $this->App->make($className)->find($key);
		$map->rules = $this->rules($className);
		$map->class_name = $className;
		$map->key = $key;
		$map->fields = $this->extractFields($mapping, $map->model, $className);
		$map->attribute_types = $this->extractAttributeTypes($map);

		return $map;
	}

	/**
	 * When we are creating a new model we will pass
	 * through a bunch of fake/dummy objects for our
	 * sidebar form
	 *
	 * @param  string $className
	 * @return ModelMap
	 */
	public function lookupWithoutKey($className)
	{
		$mapping = $this->mapping($className);

		// object for the model mapping
		$map = new \StdClass;
		$map->model = $this->App->make($className);
		$map->rules = $this->rules($className);
		$map->class_name = $className;
		$map->key = null;
		$map->fields = $this->extractNullFields($mapping, $className);
		$map->attribute_types = $this->extractAttributeTypes($map);

		return $map;
	}

	/**
	 * Creates a new model and fields
	 *
	 * We also keep up with the fields we create b/c we may need to
	 * remove them later if validation fails. We can't run validation
	 * until the fields and the events on those fields are finished, we
	 * may be picking data from the field that is only available after
	 * an event has completed and saved. This is a shortcoming of my
	 * event driven design with hooking into fields.
	 *
	 * @param  string  $className
	 * @param  integer $pageVersionId
	 * @param  array   $forms
	 * @return Eloquent\Model
	 */
	public function create($className, $pageVersionId, $forms)
	{
        $model = $this->App->make($className);

        $picks = $this->picks($className);

        $types = $this->types($className);

        $createdFields = [];

        $validationInput = [];

        foreach ($forms as $form => $values)
        {
        	$modelField = $this->newModelFieldInstance($className, $form);

        	$modelField = $this->updateModelField($modelField, $values, $types[$form]);

        	$createdFields[] = $modelField;

        	$validationInput = $this->addToValidationInput($validationInput, $modelField, $picks[$form]);

        	$model = $this->updateModelWithModelFieldsAndPicks($model, $modelField, $picks[$modelField->mapping]);

			$model = $this->updateModelWithPageVersionAndLocaleInformation($model, $pageVersionId);
        }

        try
        {
	        $this->validateModel($className, $validationInput);
        }
        catch (\Devise\Support\DeviseValidationException $e)
        {
			foreach ($createdFields as $createdField)
			{
				\DB::table($createdField->getTable())->where('id', '=', $createdField->id)->delete();
			}

			throw $e;
        }

        $model->save();

        return $model;
	}

	/**
	 * Update a given model that has been mapped
	 *
	 * @param  string $className
	 * @param  string $key
	 * @param  string $pageVersionId
	 * @param  array  $attributes
	 * @param  array  $picked
	 * @return \Illuminate\Database\Eloquent\Model
	 */
	public function update($className, $key, $pageVersionId, $forms)
	{
        $validationInput = [];

        $model = $this->App->make($className)->findOrFail($key);

        $picks = $this->picks($className);

        $types = $this->types($className);

        foreach ($forms as $form => $values)
        {
        	$modelField = $this->fieldFromClassKeyAndMappingName($className, $key, $form);

        	$modelField = $this->updateModelField($modelField, $values, $types[$modelField->mapping]);

        	$validationInput = $this->addToValidationInput($validationInput, $modelField, $picks[$modelField->mapping]);

        	$model = $this->updateModelWithModelFieldsAndPicks($model, $modelField, $picks[$modelField->mapping]);

			$model = $this->updateModelWithPageVersionAndLocaleInformation($model, $pageVersionId);
        }

        $this->validateModel($className, $validationInput);

        $model->save();

        return $model;
	}

	/**
	 * Add to the validation input array
	 *
	 * @param array      $validationInput
	 * @param ModelField $modelField
	 * @param array      $picks
	 * @return  array
	 */
	protected function addToValidationInput($validationInput, $modelField, $picks)
	{
		foreach ($picks as $attributeName => $fieldName)
		{
			$validationInput[$attributeName] = $modelField->values->get($fieldName);
		}

		return $validationInput;
	}

	/**
	 * Finds the model field from a class, key and mapping name
	 *
	 * @param  string  $className
	 * @param  integer $key
	 * @param  string  $mappingName
	 * @return ModelField
	 */
	protected function fieldFromClassKeyAndMappingName($className, $key, $mappingName)
	{
		// we have the open of passing in a field id for the mapping name
		if (is_integer($mappingName)) {
			return $this->DvsModelField->findOrFail($mappingName);
		}

		return $this->DvsModelField->whereModelType($className)
			->whereModelId($key)
			->whereMapping($mappingName)
			->firstOrFail();
	}

	/**
	 * Sometimes we will attach a page version id and/or language id
	 * on the model, if these fields exists on the model
	 *
	 * @param  Eloquent\Model $model
	 * @param  integer        $pageVersionId
	 * @return Eloquent\Model
	 */
	protected function updateModelWithPageVersionAndLocaleInformation($model, $pageVersionId)
	{
		$tableName = $model->getTable();

		$hasLanguageId = $this->Schema->hasColumn($tableName, 'language_id');

		$hasPageVersionId = $this->Schema->hasColumn($tableName, 'page_version_id');

		if ($hasPageVersionId)
		{
			$model->page_version_id = $pageVersionId;
		}

		if ($hasLanguageId)
		{
			$pageVersion = $this->PageVersion->with('page')->findOrFail($pageVersionId);
			$model->language_id = $pageVersion->page->language_id;
		}

		return $model;
	}

	/**
	 * Update this model field with values
	 *
	 * @param  integer $fieldId
	 * @param  array   $values
	 * @return ModelField
	 */
	protected function updateModelField($field, $values, $formType)
	{
		$input = $this->filterInput($values);

		$previousVersion = clone $field->values;

		$field->values->merge(array_except($input, ['page_id', 'page_version_id', 'field_scope', 'current_field_scope', 'collection_instance_id']));

		$field->json_value = $field->values->toJSON();

		$field->save();

		$this->Event->fire('devise.field.updated', [$field, $values, $previousVersion]);

		$this->Event->fire("devise.{$formType}.field.updated", [$field, $values, $previousVersion]);

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

	/**
	 * Updates the model with the model fields and picks
	 *
	 * @param  Eloquent\Model $model
	 * @param  DvsModelField  $modelField
	 * @param  array          $picks
	 * @return Eloquent\Model
	 */
	protected function updateModelWithModelFieldsAndPicks($model, $modelField, $picks)
	{
		foreach ($picks as $attributeName => $fieldName)
		{
			$model->$attributeName = $modelField->values->get($fieldName);
		}

		return $model;
	}

	/**
	 * Validate that the model values are good to go
	 *
	 * get the rules for all the attributes
	 * run the validation stuff against current values
	 * throw a InvalidDeviseException thingy in Support
	 *
	 * @param  string         $className
	 * @param  Eloquent\Model $model
	 * @return void
	 */
	protected function validateModel($className, $input)
	{
		$rules = $this->rules($className, array_keys($input));

		$validator = $this->Validator->make($input, $rules, $this->messages($className));

		if ($validator->fails())
		{
			throw new \Devise\Support\DeviseValidationException('Validation failed for this model', $validator->errors());
		}
	}

	/**
	 * Finds the pick for this given attribute and mapping
	 * that has already been looked up
	 *
	 * @param  StdClass $mapping
	 * @param  string   $attribute
	 * @return string
	 */
	protected function extractAttributeTypes($mapping)
	{
		$attributeTypes = [];

		foreach ($mapping->fields as $field)
		{
			foreach ($field->picks as $modelAttributePick => $fieldPick)
			{
				$attributeTypes[$modelAttributePick] = $field->type;
			}
		}

		return $attributeTypes;
	}

	/**
	 * This gives us an array of fields with useful information.
	 * We use this to re-use the blade views for regular fields.
	 * We inject in model specific stuff here though after recalling
	 * the field data in json form. This helps keep our dvs_model_fields
	 * `json_value` column from overriding it's models attributes (if
	 * one was to change the model manually some other place besides
	 * the front end editor)
	 *
	 * @param  array  $mapping
	 * @param  Model  $model
	 * @param  string $modelClassName
	 * @return array
	 */
	protected function extractFields($mapping, $model, $modelClassName)
	{
		$fields = [];

		foreach ($mapping['picks'] as $fieldName => $picks)
		{
			$obj = new \StdClass;

			$obj->dvs_model_field = $this->createOrFindModelField($model, $modelClassName, $fieldName, $picks);
			$obj->cid = $obj->dvs_model_field->id;
			$obj->alias = $fieldName;
			$obj->type = $mapping['types'][$fieldName];
			$obj->picks = $picks;

			$fields[] = $obj;
		}

		return $fields;
	}

	/**
	 * Null fields are fields that aren't really in the database
	 * but we need to set this stuff up so we can use views
	 * to create new models
	 *
	 * @param  string  $mapping
	 * @param  string  $modelClassName
	 * @return StdClass
	 */
	protected function extractNullFields($mapping, $modelClassName)
	{
		$fields = [];

		foreach ($mapping['picks'] as $fieldName => $picks)
		{
			$obj = new \StdClass;

			$obj->dvs_model_field = $this->newModelFieldInstance($modelClassName, $fieldName);
			$obj->cid = sha1($modelClassName . $fieldName);
			$obj->alias = $fieldName;
			$obj->type = $mapping['types'][$fieldName];
			$obj->picks = $picks;

			$fields[] = $obj;
		}

		return $fields;
	}

	/**
	 * Creates a new model field instance that doesn't
	 * save to the database
	 *
	 * @param  string $type
	 * @param  string $mapping
	 * @return DvsModelField
	 */
	protected function newModelFieldInstance($type, $mapping)
	{
		$modelField = $this->DvsModelField->newInstance();
		$modelField->model_id = 0;
		$modelField->model_type = $type;
		$modelField->mapping = $mapping;
		$modelField->json_value = '{}';

		return $modelField;
	}

	/**
	 * This searches the database for a dvs_model_field for the
	 * given model id and model class type and the mapping name of
	 * this field which needs to be unique I believe...
	 *
	 * time to try to recall the model's dvs_model_field's data
	 * this element will serve as the field that stores json values
	 * the values from this field will then be cherry picked and
	 * put into the model attributes itself
	 *
	 * @param  integer $id
	 * @param  string  $type
	 * @param  string  $fieldName
	 * @return DvsModelField
	 */
	protected function createOrFindModelField($model, $type, $mapping, $picks)
	{
		$modelField = $this->DvsModelField->whereModelId($model->id)->whereModelType($type)->whereMapping($mapping)->first();

		if (!$modelField)
		{
			$modelField = $this->DvsModelField->newInstance();
			$modelField->model_id = $model->id;
			$modelField->model_type = $type;
			$modelField->mapping = $mapping;
			$modelField->json_value = '{}';
			$modelField->save();
		}

		foreach ($picks as $modelAttribute => $fieldAttribute)
		{
			$modelField->value->merge([$fieldAttribute => $model->getAttribute($modelAttribute)]);
		}

		return $modelField;
	}

	/**
	 * All direct field picks for a given class name
	 *
	 * @param  string $className
	 * @return array
	 */
	protected function picks($className)
	{
		$mapping = $this->mapping($className);

		return $mapping['picks'];
	}

	/**
	 * All direct field picks for a given class name
	 *
	 * @param  string $className
	 * @return array
	 */
	protected function types($className)
	{
		$mapping = $this->mapping($className);

		return $mapping['types'];
	}

	/**
	 * Mapping looks to the config and gets all mappings, types and rules
	 * for this class name
	 *
	 * @param  string $className
	 * @return array
	 */
	protected function mapping($className)
	{
		if (!$this->config)
		{
			$this->config = $this->Config->get('devise.model-mapping');
		}

		return $this->config[$className];
	}

	/**
	 * List of validation messages for this class name
	 *
	 * @param  string $className
	 * @return array
	 */
	protected function messages($className)
	{
		$mapping = $this->mapping($className);

		return isset($mapping['messages']) ? $mapping['messages'] : [];
	}

	/**
	 * List of validation rules for this class name mapping
	 *
	 * @param  string $className
	 * @return array
	 */
	protected function rules($className, $filters = array())
	{
		$mapping = $this->mapping($className);

		$rules = isset($mapping['rules']) ? $mapping['rules'] : [];

		$filtered = [];

		foreach ($filters as $filter)
		{
			if (isset($rules[$filter]))
			{
				$filtered[$filter] = $rules[$filter];
			}
		}

		return count($filters) == 0 ? $rules : $filtered;
	}
}