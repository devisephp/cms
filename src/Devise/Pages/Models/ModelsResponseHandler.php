<?php namespace Devise\Pages\Models;

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
	public function __construct(ModelManager $ModelManager)
	{
		$this->ModelManager = $ModelManager;
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
		$field = $this->ModelManager->updateField($input['field'], $input['page']);

		$model = $this->ModelManager->getModelFor($fields);

		return array('model' => $model, 'field' => $field);
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
		$fields = $this->ModelManager->updateFields($input['fields'], $input['page']);

		$model = $this->ModelManager->getModelFor($fields);

		return array('model' => $model, 'fields' => $fields);
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
		$fields = $this->ModelManager->createFields($input['fields'], $input['page']);

		$model = $this->ModelManager->getModelFor($fields);

		return array('model' => $model, 'fields' => $fields);
	}
}