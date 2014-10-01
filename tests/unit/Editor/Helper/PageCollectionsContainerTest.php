<?php

class PageCollectionsContainerTest extends \DeviseTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->container = $this->app->make('Devise\Editor\Helpers\PageCollectionsContainer');
	}

	/**
	 * it should be able to merge data just fine
	 * provided there are no duplicate keys
	 */
	public function test_it_can_merge_array_data()
	{
		$this->container->merge('{"collectionKey1": [{"key": "keyname1"}, {"key": "keyname2"}], "collectionKey2": [{"key": "keyname2"}]}');
		$this->container->merge('{"collectionKey3": [{"key": "keyname1"}, {"key": "keyname2"}]}');

		assertEquals($this->container->toJSON() , '{"collectionKey1":[{"key":"keyname1"},{"key":"keyname2"}],"collectionKey2":[{"key":"keyname2"}],"collectionKey3":[{"key":"keyname1"},{"key":"keyname2"}]}');
	}

	/**
	 * it should be able to detect if a duplicate key
	 * was used or not (say on the same page or a partial)
	 *
	 * @expectedException Devise\Fields\Exceptions\DuplicateFieldKeyException
	 */
	public function test_it_can_detect_duplicated_collection_keys()
	{
		$this->container->merge('{"collectionKey1": [{"key": "keyname1"}, {"key": "keyname2"}], "collectionKey2": [{"key": "keyname2"}]}');
		$this->container->merge('{"collectionKey1": [{"key": "keyname1"}, {"key": "keyname2"}]}');
	}

	/**
	 * keys have to be unique inside of each collection too
	 * so that is another check we make
	 *
	 * @expectedException Devise\Fields\Exceptions\DuplicateFieldKeyException
	 */
	public function test_it_can_detect_duplicated_keys_inside_of_collection()
	{
		$this->container->merge('{"collectionKey1": [{"key": "keyname1"}, {"key": "keyname1"}]}');
	}

}