<?php namespace Devise\Pages\Models;

use Devise\Support\Framework;

class ModelManager
{
	/**
	 * Create a new model manager
	 *
	 * @param \DvsModelField $DvsModelField [description]
	 * @param Framework      $Framework     [description]
	 */
	public function __construct(\DvsModelField $DvsModelField, Framework $Framework)
	{
		$this->DvsModelField = $DvsModelField;
		$this->Validator = $Framework->Validator;
		$this->Event = $Framework->Event;
		$this->Container = $Framework->Container;
		$this->Schema = $Framework->Schema;
	}

	/**
	 * Updates a single field
	 *
	 * @param  [type] $field [description]
	 * @param  [type] $page  [description]
	 * @return [type]        [description]
	 */
	public function updateField($field, $page)
	{
		$fields = $this->updateFields(array($field), $page);

		return $fields[0];
	}

	/**
	 * Creates a new model from the given fields
	 *
	 * @param  array $fields
	 * @param  array $page
	 * @return array(Collection, Eloquent)
	 */
	public function createFieldsAndModel($fields, $page)
	{
		$this->removeAnyNegativeIdFields($fields);

		$fields = $this->getCreatedFields($fields, $page);

		$model = $this->createModel($fields);

		$values = $this->getValues($fields, $model, $page);

		$rules = $this->getRules($fields);

		$messages = $this->getMessages($fields);

		$validator = $this->Validator->make($values, $rules, $messages);

		if ($validator->fails())
		{
			$this->removeFields($fields);

			throw new ModelFieldValidationFailedException("Validation failed!", $validator->errors());
		}

		foreach ($values as $attribute => $value)
		{
			$model->{$attribute} = $value;
		}

		$model->save();

		foreach ($fields as $field)
		{
			$field->model_id = $model->id;
			$field->save();
		}

		return array($fields, $model);
	}

	/**
	 * Update each field in this fields array
	 *
	 * @param  [type] $fields [description]
	 * @param  [type] $page   [description]
	 * @return [type]         [description]
	 */
	public function updateFields($fields, $page)
	{
		$originals = $this->getOriginalFields($fields);

		$fields = $this->getUpdatedFields($fields);

		$model = $this->getModelFor($fields);

		$values = $this->getValues($fields, $model, $page);

		$rules = $this->getRules($fields);

		$messages = $this->getMessages($fields);

		$validator = $this->Validator->make($values, $rules, $messages);

		if ($validator->fails())
		{
			$this->restoreOriginalFields($originals);

			throw new ModelFieldValidationFailedException("Validation failed!", $validator->errors());
		}

		foreach ($values as $attribute => $value)
		{
			$model->{$attribute} = $value;
		}

		$model->save();

		return $fields;
	}

	/**
	 * Get the updated fields
	 *
	 * @param  array $fields
	 * @return Collection
	 */
	protected function getUpdatedFields($fields)
	{
		$ids = [];

		foreach ($fields as $field)
		{
			$modelField = $this->getOriginalField($field);

			$oldValues = clone $modelField->values;

			$newValues = array_get($field, 'values', []);

			$modelField->values->override($newValues);

			// probably want to add content_requested to model fields later?
        	// $modelField->content_requested = array_get($field, 'content_requested', false);

	        $modelField->json_value = $modelField->values->toJSON();

			$modelField->save();

			$this->Event->fire('devise.field.updated', [$modelField, $newValues, $oldValues]);

			$this->Event->fire("devise.{$modelField->type}.field.updated", [$modelField, $newValues, $oldValues]);

			$ids[] = $modelField->id;
		}

		if (!$ids) return [];

		return $this->DvsModelField->whereIn('id', $ids)->get();
	}

	/**
	 * Restores the original fields, since validation failed
	 *
	 * @param  Collection $original [description]
	 * @return void
	 */
	protected function restoreOriginalFields($originals)
	{
		$ids = [];

		foreach ($originals as $original)
		{
			$ids[] = $original->id;
			$field = $this->DvsModelField->newInstance()->find($original->id);
			$field->json_value = $original->json_value;
			$field->save();
		}

		return $this->DvsModelField->newInstance()->whereIn('id', $ids)->get();
	}

	/**
	 * Gets all the original fields in place of the
	 * modified fields... this is useful for when
	 * our validation fails
	 *
	 * @param  [type] $fields [description]
	 * @return [type]         [description]
	 */
	protected function getOriginalFields($fields)
	{
		$ids = [];

		foreach ($fields as $field)
		{
			$ids[] = $field['id'];
		}

		return $this->DvsModelField->newInstance()->whereIn('id', $ids)->get();
	}

	/**
	 * Gets the original field in place of the
	 * modified field
	 *
	 * @param  [type] $field [description]
	 * @return [type]        [description]
	 */
	protected function getOriginalField($field)
	{
		return $this->DvsModelField->newInstance()->find($field['id']);
	}

	/**
	 * Gets the picked values for the entered fields
	 *
	 * @param  array    $fields
	 * @param  Eloquent $model
	 * @return array
	 */
	protected function getValues($fields, $model, $page)
	{
		$values = array_except($model->toArray(), ['id', 'created_at', 'updated_at', 'deleted_at']);

		foreach ($fields as $field)
		{
			foreach ($field->picks as $modelAttribute => $fieldAttribute)
			{
				$values[$modelAttribute] = $field->values->get($fieldAttribute, null);
			}
		}

		if ($this->Schema->hasColumn($model->getTable(), 'page_version_id')) {
			$values['page_version_id'] = $page['page_version_id'];
		}

		if ($this->Schema->hasColumn($model->getTable(), 'language_id')) {
			$values['language_id'] = $page['language_id'];
		}

		return $values;
	}

	/**
	 * Get the rules for these fields
	 *
	 * @param  [type] $fields [description]
	 * @return [type]         [description]
	 */
	protected function getRules($fields)
	{
		$rules = count($fields) > 0 ? $fields[0]->rules : [];

		return $rules;
	}

	/**
	 * Get the messages for these fields
	 *
	 * @param  [type] $fields [description]
	 * @return [type]         [description]
	 */
	protected function getMessages($fields)
	{
		$messages = count($fields) > 0 ? $fields[0]->messages : [];

		return $messages;
	}

	/**
	 * Get the field's model
	 *
	 * @param  array $fields
	 * @return Eloquent
	 */
	protected function getModelFor($fields)
	{
		$field = count($fields) > 0 ? $fields[0] : $fields;

		$model = $field ? $field->model : null;

		return $model;
	}

	/**
	 * Removes these fields since the validation failed...
	 *
	 * @param  [type] $fields [description]
	 * @return [type]         [description]
	 */
	protected function removeFields($fields)
	{
		foreach ($fields as $field)
		{
			$field->forceDelete();
		}
	}

	/**
	 * Creates a new model for the first field
	 * type it finds
	 *
	 * @param  [type] $fields [description]
	 * @return [type]         [description]
	 */
	protected function createModel($fields)
	{
		return $this->Container->make($fields[0]['model_type']);
	}

	/**
	 * [createFields description]
	 * @param  [type] $fields [description]
	 * @return [type]         [description]
	 */
	protected function getCreatedFields($fields)
	{
		$ids = [];

		foreach ($fields as $field)
		{
			$modelField = $this->getCreatedField($field);

			$oldValues = clone $modelField->values;

			$newValues = array_get($field, 'values', []);

			$modelField->values->override($newValues);

			// probably want to add content_requested to model fields later?
        	// $modelField->content_requested = array_get($field, 'content_requested', false);

	        $modelField->json_value = $modelField->values->toJSON();

			$modelField->save();

			$this->Event->fire('devise.field.updated', [$modelField, $newValues, $oldValues]);

			$this->Event->fire("devise.{$modelField->type}.field.updated", [$modelField, $newValues, $oldValues]);

			$ids[] = $modelField->id;
		}

		if (!$ids) return [];

		return $this->DvsModelField->whereIn('id', $ids)->get();
	}

	/**
	 * Creates a new model field
	 *
	 * @param  [type] $field [description]
	 * @return [type]        [description]
	 */
	protected function getCreatedField($field)
	{
		$modelField = $this->DvsModelField->newInstance();
		$modelField->model_id = -1 * $this->DvsModelField->newInstance()->count();
		$modelField->model_type = $field['model_type'];
		$modelField->mapping = $field['mapping'];
		return $modelField;
	}

	/**
	 * Sometimes errors and stuff can cause invalid model
	 * fields in our database... this just removes any
	 * just in case...
	 *
	 * @param  [type] $fields [description]
	 * @return [type]         [description]
	 */
	protected function removeAnyNegativeIdFields($fields)
	{
		$mappings = [];
		$modelType = '';

		foreach ($fields as $field)
		{
			$modelType = $field["model_type"];
			$mappings[] = $field['mapping'];
		}

		if (!$mappings) return;

		$modelFields = $this->DvsModelField->newInstance()
			->withTrashed()
			->where('model_id', '<', 1)
			->where('model_type', '=', $modelType)
			->whereIn('mapping', $mappings)
			->get();

		foreach ($modelFields as $modelField)
		{
			$modelField->forceDelete();
		}
	}
}