<?php namespace Devise\Common;

use Illuminate\Support\Facades\Validator;

abstract class Manager
{
	use \Devise\MessageBus;

	public $errors, $message, $messages = array();

	/**
	 * Validate the input with the rules
	 *
	 * @param  array $input
	 * @param  array $rules
	 * @param  string $message
	 * @return array
	 */
	protected function validate($input, $rules, $message = "Validation failed")
	{
		$validator = Validator::make($input, $rules, $this->messages);

		$passes = $validator->passes();

		if (!$passes)
		{
			$this->errors = $validator->errors();
			$this->message = $message;
		}

		return $passes;
	}

	/**
	 * Assert that this is valid, if not it throws a validation exception
	 *
	 * @param  array $input
	 * @param  array $rules
	 * @param  string $message
	 * @return void
	 */
	protected function assertValid($input, $rules, $message = "Validation failed")
	{
		$this->validate($input, $rules, $message);

		if ($this->errors)
		{
			throw new ValidationException($this->message, $this->errors);
		}
	}

	/**
	 * Validate the input with the rules
	 *
	 * @param  array $input
	 * @param  array $rules
	 * @param  string $message
	 * @return array
	 */
	protected function fails($input, $rules, $message = "Validation failed")
	{
		return !$this->validate($input, $rules, $message);
	}

	/**
	 * Validate the input with the rules
	 *
	 * @param  array $input
	 * @param  array $rules
	 * @param  string $message
	 * @return array
	 */
	protected function passes($input, $rules, $message = "Validation failed")
	{
		return $this->validate($input, $rules, $message);
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

}