<?php namespace Devise\Pages\Models;

use Devise\Support\Framework;

class ModelsResponseHandler
{
	/**
	 * Model Manager
	 *
	 * @var ModelManager
	 */
	protected $ModelManager;

	/**
	 * Create a new model manager
	 *
	 * @param ModelManager $ModelManager
	 */
	public function __construct(ModelManager $ModelManager, Framework $Framework)
	{
		$this->ModelManager = $ModelManager;
		$this->Response = $Framework->Response;
	}

	/**
	 * Updates a single model field for this model (attribute)
	 *
	 * @param  integer $modelFieldId
	 * @param  array   $input
	 * @return array
	 */
	public function executeModelFieldUpdate($modelFieldId, $input)
	{
		try
		{
			$field = $this->ModelManager->updateField($input['field'], $input['page']);
		}

		catch (ModelFieldValidationFailedException $e)
		{
			return $this->Response->json([
				'errors' => $e->getErrors()
			], 403);
		}

		return array('field' => $field);
	}

	/**
	 * Loops over all fields for this model and updates
	 * the model with new values (model)
	 *
	 * @param  array $input
	 * @return array
	 */
	public function executeModelFieldsUpdate($input)
	{
		try {
			$fields = $this->ModelManager->updateFields($input['fields'], $input['page']);
		} catch (ModelFieldValidationFailedException $e) {
			return $this->Response->json(['errors' => $e->getErrors()], 403);
		}

		return array('fields' => $fields);
	}

	/**
	 * Model creators use this to create new model fields
	 * for a model (model creator)
	 *
	 * @param  array $input
	 * @return array
	 */
	public function executeModelFieldsCreate($input)
	{
		try {
			list($fields, $model) = $this->ModelManager->createFieldsAndModel($input['fields'], $input['page']);
		} catch (ModelFieldValidationFailedException $e) {
			return $this->Response->json(['errors' => $e->getErrors()], 403);
		}

		return array('model' => $model, 'fields' => $fields);
	}
}