<?php namespace Devise\Fields\Models;

class FieldValue
{
	protected $json;

	public function __construct($json)
	{
		$this->json = $json;
		$values = json_decode($json);

		foreach ($values as $key => $value)
		{
			$this->$key = $value;
		}
	}

	public function __toString()
	{
		return '';
	}

	public function __get($name)
	{
		return $this;
	}

	public function merge($input)
	{
		$values = (array) json_decode($this->json);

		$values = array_merge($values, $input);

		$this->json = json_encode($values);

		// add the new inputs to our existing object
		// or else our json representation will be
		// out of sync with our values on this FieldValue
		foreach ($input as $key => $value)
		{
			$this->$key = $value;
		}
	}

	public function toJSON()
	{
		return $this->json;
	}

	public function __call($name, $args)
	{
		$default = count($args) > 0 ? $args[0] : '';

		$value = $this->{$name};

		return is_a($value, 'Devise\Fields\Models\FieldValue') ? $default : $value;
	}
}