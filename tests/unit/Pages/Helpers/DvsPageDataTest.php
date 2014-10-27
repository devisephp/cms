<?php namespace Devise\Pages\Helpers;

class DvsPageDataTest extends \DeviseTestCase
{
	public function setUp()
	{
		$this->dvsPageData = new DvsPageData;
	}

	public function test_it_can_add_collections()
	{
		$this->dvsPageData->addCollection('col', 'keyname5', 'type', 'humanName', 'groupName', 'categoryName', null);
		assertEquals('{"col":[{"collection":"col","key":"keyname5","type":"type","humanName":"humanName","group":"groupName","category":"categoryName","alternateTarget":null}]}', $this->dvsPageData->collectionsJSON());
	}

	public function test_it_can_add_bindings()
	{
		$this->dvsPageData->addBinding('keyname1', 'type', 'humanName', null, null, null);
		assertEquals('[{"key":"keyname1","type":"type","humanName":"humanName","group":null,"category":null,"alternateTarget":null}]', $this->dvsPageData->bindingsJSON());
	}

	/**
	 * @expectedException Devise\Pages\Interrupter\Exceptions\DuplicateDeviseKeyException
	 */
	public function test_it_checks_for_duplicated_keys()
	{
		$this->dvsPageData->addBinding('keyname1', 'type', 'humanName', null, null, null);
		$this->dvsPageData->addBinding('keyname1', 'type', 'humanName', null, null, null);
	}
}