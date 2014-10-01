<?php

class PageBindingsContainerTest extends \DeviseTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->container = $this->app->make('Devise\Editor\Helpers\PageBindingsContainer');
	}

	/**
	 * it should be able to merge data just fine
	 * provided there are no duplicate keys
	 */
	public function test_it_can_merge_array_data()
	{
		$this->container->merge('[{"key": "keyname1"}, {"key": "keyname2"}]');
		$this->container->merge('[{"key": "keyname3"}, {"key": "keyname4"}]');

		assertEquals($this->container->toJSON(), '[{"key":"keyname1"},{"key":"keyname2"},{"key":"keyname3"},{"key":"keyname4"}]');
	}

	/**
	 * cannot have two keys be the same on the same page, that
	 * would cause us lots of problems
	 *
	 * @expectedException Devise\Fields\Exceptions\DuplicateFieldKeyException
	 */
	public function test_it_cannot_merge_duplicate_keys()
	{
		$this->container->merge('[{"key": "keyname1"}, {"key": "keyname2"}]');
		$this->container->merge('[{"key": "keyname2"}, {"key": "keyname4"}]');
	}

	/**
	 * what happens when there is no key defined
	 * what do we do?
	 *
	 * @expectedException Devise\Fields\Exceptions\InvalidFieldKeyException
	 */
	public function test_it_can_handle_no_keys_with_exception()
	{
		$this->container->merge('[{"nokey": "on this element"}]');
	}


}