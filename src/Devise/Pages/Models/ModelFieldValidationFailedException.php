<?php namespace Devise\Pages\Models;

class ModelFieldValidationFailedException extends \Exception
{
	protected $errors;

	public function __construct($message, $errors)
	{
		parent::__construct($message);
		$this->errors = $errors;
	}

	public function getErrors()
	{
		return $this->errors;
	}
}