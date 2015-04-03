<?php namespace Devise\Pages\Models;

use Devise\Support\Framework;
use Devise\Support\DeviseException;

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
	public function __construct(\DvsModelField $DvsModelField, Framework $Framework)
	{
		$this->DvsModelField = $DvsModelField;
		$this->App = $Framework->Container;
		$this->Config = $Framework->Config;
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

		$model = $this->App->make($className)->find($key);

		if (!$model) {
			throw new ModelNotFoundException("Could not find {$className} with id of {$key}");
		}

		// object for the model mapping
		$map = new \StdClass;
		$map->model = $model;
		$map->rules = $this->rules($className);
		$map->messages = $this->messages($className);
		$map->class_name = $className;
		$map->key = $key;
		$map->fields = $this->extractFields($mapping, $model, $className);
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
		$map->messages = $this->messages($className);
		$map->class_name = $className;
		$map->key = null;
		$map->fields = $this->extractNullFields($mapping, $className);
		$map->attribute_types = $this->extractAttributeTypes($map);

		return $map;
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
		$modelField = $this->DvsModelField
			->newInstance()
			->whereModelId($model->id)
			->whereModelType($type)
			->whereMapping($mapping)
			->first();

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

		if (! array_key_exists($className, $this->config))
		{
			throw new DeviseException('No model mapping configuration found for ' . $className);
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