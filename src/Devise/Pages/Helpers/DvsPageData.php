<?php namespace Devise\Pages\Helpers;

use Devise\Pages\Interrupter\Exceptions\DuplicateDeviseKeyException;

class DvsPageData
{
	/**
	 * Keep track of all the page collections
	 * @var array
	 */
	protected $collections = [];

	/**
	 * Keep track of all the page bindings
	 * @var array
	 */
	protected $bindings = [];

	/**
	 * Keep track of all the added keys
	 * @var array
	 */
	protected $addedKeys = [];

	/**
	 * Collections as json output
	 *
	 * @return string
	 */
	public function collectionsJSON()
	{
		return json_encode($this->collections);
	}

	/**
	 * Bindings as json output
	 *
	 * @return string
	 */
	public function bindingsJSON()
	{
		return json_encode($this->bindings);
	}

	/**
	 * Add a collection to dvsPageData
	 *
	 * @param string $collection
	 * @param string $key
	 * @param string $type
	 * @param string $humanName
	 * @param string $group
	 * @param string $category
	 * @param string $alternateTarget
	 */
	public function addCollection($collection, $key, $type, $humanName, $group, $category, $alternateTarget)
	{
		$this->assertUniqueCollectionKey($collection, $key);

		$this->addedKeys[] = "{$collection}[{$key}]";

		$this->collections[$collection] = isset($this->collections[$collection]) ? $this->collections[$collection] : array();

		$this->collections[$collection][] = [
			'collection' => $collection,
			'key' => $key,
			'type' => $type,
			'humanName' => $humanName,
			'group' => $group,
			'category' => $category,
			'alternateTarget' => $alternateTarget
		];
	}

	/**
	 * Add a binding to dvsPageData
	 *
	 * @param string $key
	 * @param string $type
	 * @param string $humanName
	 * @param string $group
	 * @param string $category
	 * @param string $alternateTarget
	 */
	public function addBinding($key, $type, $humanName, $group, $category, $alternateTarget)
	{
		$this->assertUniqueBindingKey($key);

		$this->addedKeys[] = "{$key}";

		$this->bindings[] = [
			'key' => $key,
			'type' => $type,
			'humanName' => $humanName,
			'group' => $group,
			'category' => $category,
			'alternateTarget' => $alternateTarget
		];
	}

	/**
	 * Make sure the key is unique to the page
	 * bindings
	 *
	 * @param  string $key
	 * @return void
	 */
	protected function assertUniqueBindingKey($key)
	{
		if (in_array($key, $this->addedKeys))
		{
			throw new DuplicateDeviseKeyException('Found duplicate key ' . $key);
		}
	}

	/**
	 * Make sure this key is unique to the collection
	 *
	 * @param  string $collection
	 * @param  string $key
	 * @return void
	 */
	protected function assertUniqueCollectionKey($collection, $key)
	{
		$this->assertUniqueBindingKey("{$collection}[{$key}]");
	}
}