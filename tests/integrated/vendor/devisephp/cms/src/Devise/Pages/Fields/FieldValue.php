<?php namespace Devise\Pages\Fields;

/**
 * Field value is an object that holds json
 * values for a DvsField model
 *
 */
class FieldValue
{
	/**
	 * Json string
	 *
	 * @var string
	 */
	protected $json;

	/**
	 * Create a new FieldValue object from json string
	 *
	 * @param string $json
	 */
	public function __construct($json)
	{
		$this->json = $json;
		$values = json_decode($json);

		foreach ($values as $key => $value)
		{
			$this->$key = $value;
		}
	}

	/**
	 * Convert to a empty string to avoid
	 * null pointer exceptions
	 *
	 * @return string
	 */
	public function __toString()
	{
		return '';
	}

	/**
	 * Avoids null pointer exceptions by
	 * treating this like the empty string
	 * we only ever reach this magical method
	 * when we have attempted to fetch a key
	 * that does not exist on this FieldValue object
	 *
	 * @param  string $name
	 * @return FieldValue
	 */
	public function __get($name)
	{
		return $this;
	}

	/**
	 * Gets this field with this name, returns
	 * default if nothing is found...
	 *
	 * @param  string $name
	 * @param  mixed  $default
	 * @return mixed
	 */
	public function get($name, $default = null)
	{
		$value = $this->{$name};

		return is_a($value, 'Devise\Pages\Fields\FieldValue') ? $default : $value;
	}

	/**
	 * Merges in the array data into the
	 * field object json
	 *
	 * @param  array $input
	 * @return void
	 */
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

	/**
	 * Returns this object as json string
	 *
	 * @return string
	 */
	public function toJSON()
	{
		return $this->json;
	}

	/**
	 * Allows us to set default values on a key
	 * if we do not have that key set in this
	 * FieldValue object
	 *
	 * @param  string $name
	 * @param  mixed $args
	 * @return mixed
	 */
	public function __call($name, $args)
	{
		$default = count($args) > 0 ? $args[0] : '';

		return $this->get($name, $default);
	}
}