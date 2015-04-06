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
		$original = $this->getOriginalFields($fields);

		$fields = $this->getUpdatedFields($fields, $page);

		$model = $this->getModelFor($fields);

		$values = $this->getValues($fields, $model);

		$rules = $this->getRules($fields);

		$validator = $this->Validator->make($values, $rules);

		if ($validator->fails())
		{
			$this->restoreOriginalFields($original);

			throw new ModelFieldValidationFailedException("Validation failed!", $validator->errors(), $original, $model);
		}

		foreach ($values as $attribute => $value)
		{
			$model->{$attribute} = $value;
		}

		// $model->save();

		return $fields;
	}

	/**
	 * Get the updated fields
	 *
	 * @param  array $fields
	 * @return Collection
	 */
	protected function getUpdatedFields($fields, $page)
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
	protected function restoreOriginalFields($original)
	{
		foreach ($original as $field)
		{
			$field->save();
		}
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
	protected function getValues($fields, $model)
	{
		dd($fields);
		$fields = is_array($fields) ? $fields : array($fields);

		return [];
	}

	/**
	 * [createFields description]
	 * @param  [type] $fields [description]
	 * @param  [type] $page   [description]
	 * @return [type]         [description]
	 */
	public function createFields($fields, $page)
	{
		return $fields;
	}

	/**
	 * Get the field's model
	 *
	 * @param  array $fields
	 * @return Eloquent
	 */
	public function getModelFor($fields)
	{
		$field = count($fields) > 0 ? $fields[0] : $fields;

		$model = $field ? $field->model : null;

		return $model;
	}
}