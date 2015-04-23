<?php namespace Devise\Support;

/**
 * This validation exception is thrown
 * when ever there are validation errors
 * somewhere. It is used in the Manager class
 * to assert fields are valid.
 */
class DeviseValidationException extends DeviseException
{
	/**
	 * MessageBag of validation errors
	 *
	 * @var array
	 */
	protected $errors;

	/**
	 * Construct a new Validation exception
	 *
	 * @param string $message
	 * @param \Illuminate\Support\MessageBag  $errors
	 */
	public function __construct($message, $errors)
	{
		parent::__construct($message);
		$this->errors = $errors;
	}

	/**
	 * Access the errors message bag
	 *
	 * @return \Illuminate\Support\MessageBag
	 */
	public function getErrors()
	{
		return $this->errors;
	}
}