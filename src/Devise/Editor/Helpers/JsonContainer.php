<?php namespace Devise\Editor\Helpers;

use Devise\Fields\Exceptions\DuplicateFieldKeyException;
use Devise\Fields\Exceptions\InvalidFieldKeyException;

/**
 * Purpose of this class is to hold on json
 * values for data-devise bindings in the IoC
 * container... those will be spit out in
 * the devise::scripts view...
 *
 */
class JsonContainer
{
	protected $data;

	public function __construct()
	{
		$this->data = array();
	}

	/**
	 * Merge the data into this class... it allows
	 * us to have data-devise on multi-pages
	 *
	 * @param  string/array $data
	 * @return void
	 */
	public function merge($data)
	{
		$data = is_string($data) ? json_decode($data) : $data;

		$data = (array) $data;

		$this->assertValidData($data);

		$this->data = array_merge($this->data, $data);
	}

	/**
	 * Outputs this data out as json string
	 *
	 * @return string
	 */
	public function toJSON()
	{
		return json_encode($this->data);
	}

	/**
	 * Outputs this data as just regular data
	 * in case we want to tamper or examine it
	 *
	 * @return array
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * Placeholder method to be used by children classes
	 *
	 * @return void
	 */
	protected function assertValidData($data)
	{
		// do nothing here, meant to be overridden
	}

	/**
	 * Make sure there are no duplicated keys
	 * in these two arrays that are passed in
	 *
	 * @param  array $keys
	 * @param  array $newKeys
	 * @return void
	 */
	protected function assertNoDuplicateKeys($keys, $newKeys)
	{
		$duplicates = array_intersect($keys, $newKeys);

		// no duplicates between $this->data and $data
		if ($duplicates)
		{
			$duplicate = array_shift($duplicates);
			throw new DuplicateFieldKeyException('Found duplicate data-devise collection key for "' . $duplicate . '"');
		}

		// no duplicates found inside of $data
		if (count($newKeys) != count(array_unique($newKeys)))
		{
			$duplicate = $this->findDuplicatedKey($newKeys);
			throw new DuplicateFieldKeyException('Found duplicate data-devise collection key for "' . $duplicate . '"');
		}

		// no duplicates found inside of $this->data
		if (count($keys) != count(array_unique($keys)))
		{
			$duplicate = $this->findDuplicatedKey($keys);
			throw new DuplicateFieldKeyException('Found duplicate data-devise collection key for "' . $duplicate . '"');
		}
	}

	/**
	 * Find a duplicated key in this list
	 *
	 * @param  array $keys
	 * @return string
	 */
	protected function findDuplicatedKey($keys)
	{
		$duplicated = array_reverse(array_flip(array_count_values($keys)));
		return array_shift($duplicated);
	}

	/**
	 * Gets an array of all the keys for all bindings
	 *
	 * @param  array $data
	 * @return array
	 */
	protected function keysFor($data)
	{
		return array_map(function($array)
		{
			if (!isset($array->key)) throw new InvalidFieldKeyException('No key was found for a binding, all bindings must have a key!');
			return $array->key;
		}, $data);
	}
}