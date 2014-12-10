<?php namespace Devise\Pages\Interrupter;

/**
 * A storage container class that stores collections and fields
 * for a given page. These fields and collections are addeded
 * to a singleton registered in Devise\Pages\PagesServiceProvider.php
 * called 'dvsPageData'. ALl blade views that contain fields and/or
 * collections will use methods like addCollection and addField respectively
 * to add in the data. Eventually all this data is spit out as JSON
 * for the javascript library in devise to take over from there.
 */
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
     * @throws Exceptions\DuplicateDeviseKeyException
     * @return void
     */
	protected function assertUniqueBindingKey($key)
	{
		if (in_array($key, $this->addedKeys))
		{
			throw new Exceptions\DuplicateDeviseKeyException('Found duplicate key ' . $key);
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