<?php namespace Devise\Pages\Models;

class ModelFieldValidationFailedException extends \Exception
{
	protected $errors;

	protected $fields;

	protected $model;

	public function __construct($message, $errors, $fields, $model)
	{
		parent::__construct($message);

		$this->errors = $errors;
		$this->fields = $fields;
		$this->model = $model;
	}

	public function getErrors()
	{
		return $this->errors;
	}

	public function getFields()
	{
		return $this->fields;
	}

	public function getModel()
	{
		return $this->model;
	}
}