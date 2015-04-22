<?php namespace Devise\Pages\Fields;

use Devise\Support\Framework;

/**
 * Field value is an object that holds json
 * values for a DvsField model
 *
 */
class LiveFieldValue
{
	/**
	 * stores all the relavent data for us in here
	 * so we don't conflict with outside values
	 *
	 * @var string
	 */
	protected $__;

	/**
	 * Create a new FieldValue object from json string
	 *
	 * @param string $json
	 */
	public function __construct($json, $fieldId, $type)
	{
		$this->__ = new \StdClass;
		$this->__->json = $json;
		$this->__->id = $fieldId;
		$this->__->type = $type;
		$this->__->value = '';
		$this->__->values = (array) json_decode($this->__->json);
		$this->extract();
	}

	/**
	 * [__id description]
	 * @return [type]
	 */
	public function __id()
	{
		return $this->__->id;
	}

	/**
	 * [__type description]
	 * @return [type]
	 */
	public function __type()
	{
		return $this->__->type;
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
		return $this->get($name, $this);
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

	/**
	 * This thing is just a string...
	 *
	 * @return string
	 */
	public function __toString()
	{
		return '';
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
		$value = isset($this->__->values[$name]) ? $this->__->values[$name] : $default;

		return $value ?: $default;
	}

	/**
	 * Overrides this data with the new
	 * input array
	 *
	 * @param  array $input
	 * @return void
	 */
	public function override(array $input)
	{
		$this->unextract();
		$this->__->values = $input;
		$this->__->json = json_encode($this->__->values);
		$this->extract();
	}

	/**
	 * Merges in the array data into the
	 * field object json
	 *
	 * @param  array $input
	 * @return void
	 */
	public function merge(array $input)
	{
		$this->__->values = array_merge($this->__->values, $input);
		$this->__->json = json_encode($this->__->values);
		$this->extract();
	}

	/**
	 * This extracts the variables so they may be used.
	 * This is not recommended to do as it will
	 * mess up LiveUpdate, but it is needed in certain
	 * cases (for example in FieldManager)
	 *
	 * @return void
	 */
	public function extract()
	{
		foreach ($this->__->values as $key => $value)
		{
			$this->{$key} = $value;
		}
	}

	/**
	 * Un extracts all the keys on this thing
	 * could be useful if we need to undo an extract
	 *
	 * @return void
	 */
	public function unextract()
	{
		foreach ($this->__->values as $key => $value)
		{
			unset($this->{$key});
		}
	}

	/**
	 * Returns this object as json string
	 *
	 * @return string
	 */
	public function toJSON()
	{
		return $this->__->json;
	}

	/**
	 * Returns this object as array
	 *
	 * @return array
	 */
	public function toArray()
	{
		return $this->__->values;
	}
}