<?php namespace Devise\Editor\Helpers;

/**
 * Purpose of this class is to hold on json
 * values for data-devise bindings in the IoC
 * container... those will be spit out in
 * the devise::scripts view...
 *
 */
class PageCollectionsContainer extends JsonContainer
{
	/**
	 * Make sure that there are no duplicated keys
	 * inside of the collections
	 *
	 * @return void
	 */
	protected function assertValidData($data)
	{
		$this->assertNoDuplicatedCollectionKeys($data);
		$this->assertNoDuplicatedFieldKeys($data);
	}

	/**
	 * Make sure that there are no duplicated
	 * collection keys in this list
	 *
	 * @param  array $data
	 * @return void
	 */
	protected function assertNoDuplicatedCollectionKeys($data)
	{
		$keys = array_keys($this->data);
		$newKeys = array_keys($data);
		$this->assertNoDuplicateKeys($keys, $newKeys);
	}

	/**
	 * Make sure that the fields in each collection are
	 * unique to that collection
	 *
	 * @param  array $data
	 * @return void
	 */
	protected function assertNoDuplicatedFieldKeys($data)
	{
		foreach ($data as $collectionKey => $fields)
		{
			$newKeys = $this->keysFor($fields);
			$this->assertNoDuplicateKeys(array(), $newKeys);
		}
	}

}