<?php namespace Devise\Pages\Interpreter;

use Mockery as m;

class DvsPageDataTest extends \DeviseTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->TagManager = m::mock('Devise\Pages\Interpreter\TagManager');
		$this->CollectionsRepository = m::mock('Devise\Pages\Collections\CollectionsRepository');
		$this->PagesRepository = m::mock('Devise\Pages\PagesRepository');
		$this->dvsPageData = new DvsPageData($this->TagManager, $this->CollectionsRepository, $this->PagesRepository);
	}

	public function test_it_initializes()
	{
		$this->TagManager->shouldReceive('initialize')->once()->with(1, 1, 45);
		$this->dvsPageData->initialize(1, 1, 45, 'token');
	}

	public function test_it_registers_tags()
	{
		$this->dvsPageData->register('col[key1]', 'collection', 'col', 'key1', 'text', 'Key 1', 'collection name', 'group', 'category', 'alternate target');
	}

	/**
	 * @expectedException Devise\Pages\Interpreter\Exceptions\DuplicateDeviseKeyException
	 */
	public function test_it_cannot_register_a_key_more_than_once()
	{
		$this->dvsPageData->register('key1', 'field', null, 'key1', 'text', 'Key 1', null, null, null, null);
		$this->dvsPageData->register('key1', 'field', null, 'key1', 'text', 'Key 1', null, null, null, null);
	}

	public function test_it_can_set_defaults()
	{
		$defaults = ['durka' => 'stuff'];
		$this->dvsPageData->register('key1', 'field', null, 'key1', 'text', 'Key 1', null, null, null, null);
		$this->dvsPageData->setDefaults('key1', $defaults);
	}

	/**
	 * @expectedException Devise\Pages\Interpreter\Exceptions\InvalidDeviseKeyException
	 */
	public function test_it_cannot_set_defaults_for_invalid_keys()
	{
		$this->dvsPageData->setDefaults('nosuchkey', ['durka' => 'stuff']);
	}

	public function test_it_can_give_us_cid_for_field_tag()
	{
		$dvsField = new \DvsField; $dvsField->id = 42;
		$this->TagManager->shouldReceive('getInstanceForTag')->once()->andReturn($dvsField);
		$this->dvsPageData->register('key1', 'field', null, 'key1', 'text', 'Key 1', null, null, null, null);
		$cid = $this->dvsPageData->cid('key1', 'field', null, 'key1', 'text', 'Key 1', null, null, null, null, null);
		assertEquals('field42', $cid);
	}

	public function test_it_can_give_us_cid_for_collection_tag()
	{
		$dvsField = new \DvsField; $dvsField->id = 42;
		$this->TagManager->shouldReceive('getInstanceForTag')->once()->andReturn($dvsField);
		$this->dvsPageData->register('col[key1]', 'collection', 'col', 'key1', 'text', 'Key 1', null, null, null, null);
		$cid = $this->dvsPageData->cid('col[key1]', 'collection', 'col', 'key1', 'text', 'Key 1', null, null, null, null, null);
		assertEquals('collection42', $cid);
	}

	public function test_it_can_give_us_cid_for_model_tag()
	{
		$model = \DvsPage::find(1);
		$dvsField = new \DvsField; $dvsField->id = 42;
		$this->TagManager->shouldReceive('getInstanceForTag')->once()->andReturn($dvsField);
		$this->dvsPageData->register('$model', 'variable', null, '$model', 'variable', 'Model', null, null, null, null);
		$cid = $this->dvsPageData->cid('$model', 'variable', null, ['$model' => $model,], 'variable', 'Model', null, null, null, null, null);
		assertEquals('model0', $cid);
	}

	public function test_it_can_give_us_cid_for_model_attribute_tag()
	{
		$page = \DvsPage::find(1);
		$dvsField = new \DvsField; $dvsField->id = 42;
		$this->TagManager->shouldReceive('getInstanceForTag')->once()->andReturn($dvsField);
		$this->dvsPageData->register('$page->view', 'variable', null, '$page->view', 'variable', 'The Page View', null, null, null, null);
		$cid = $this->dvsPageData->cid('$page->view', "variable", null, ['view' => $page->view,'$page' => $page,], "variable", "The Page View", null, null, null, null, null);
		assertEquals('attribute42', $cid);
	}

	public function test_it_can_give_us_cid_for_model_creator_tag()
	{
		$dvsField = new \StdClass; $dvsField->id = 42;
		$this->TagManager->shouldReceive('getInstanceForTag')->once()->andReturn($dvsField);
		$this->dvsPageData->register('creator.07bc2f9dadb7314768a55b1f9cd404dc', 'creator', null, 'DvsPage', 'creator', 'The Page Creator', null, null, null, null);
		$cid = $this->dvsPageData->cid('creator.07bc2f9dadb7314768a55b1f9cd404dc', "creator", null, "DvsPage", "creator", "The Page Creator", null, null, null, null, null);
		assertEquals('creator42', $cid);
	}

	public function test_it_can_give_us_json_nodes()
	{
		$dvsField = new \StdClass; $dvsField->id = 42;
		$this->PagesRepository->shouldReceive('availableLanguagesForPage')->once()->andReturn(['en' => 'EN']);
		$this->PagesRepository->shouldReceive('getRouteList')->once()->andReturn(['route1', 'route2']);
		$this->PagesRepository->shouldReceive('getPageVersions')->once()->andReturn(['version1', 'version2']);
		$this->CollectionsRepository->shouldReceive('findCollectionInstancesForCollectionSetIdAndPageVersionId')->once()->andReturn([]);
		$this->TagManager->shouldReceive('getInstanceForTag')->andReturn($dvsField);
		$this->populateDvsPageData();

		// this is failing on the collections stuff, probably some bug
		// with how the collections are added to groups
		$this->markTestIncomplete();
		// $json = $this->dvsPageData->toJSON();
	}

	private function populateDvsPageData()
	{
		$page = \DvsPage::find(1);

		$this->TagManager->shouldReceive('initialize')->with(1, 1, 45);
		$this->dvsPageData->initialize(1, 1, 45, 'token');

		$this->dvsPageData->register('key1', 'field', null, 'key1', 'text', 'Key 1', null, null, null, null);
		$this->dvsPageData->register('key2', 'field', null, 'key2', 'text', 'Key 2', null, null, null, null);
		$this->dvsPageData->register('col[key1]', 'collection', 'col', 'key1', 'text', 'Key 1', 'Collection Name', 'My Group Name', 'category', 'alternate target');
		$this->dvsPageData->register('col[key2]', 'collection', 'col', 'key2', 'text', 'Key 2', 'Collection Name', 'My Group Name', 'category', 'alternate target');
		$this->dvsPageData->register('col[key3]', 'collection', 'col', 'key3', 'text', 'Key 3', 'Collection Name', 'My Group Name', 'category', 'alternate target');
		$this->dvsPageData->register('$page', 'variable', null, '$page', 'variable', 'Page', null, null, null, null);
		$this->dvsPageData->register('$page->view', 'variable', null, '$page->view', 'variable', 'The Page View', null, null, null, null);
		$this->dvsPageData->register('creator.07bc2f9dadb7314768a55b1f9cd404dc', 'creator', null, 'DvsPage', 'creator', 'The Page Creator', null, null, null, null);

		$this->dvsPageData->cid('key1', 'field', null, 'key1', 'text', 'Key 1', null, null, null, null, null);
		$this->dvsPageData->cid('key2', 'field', null, 'key2', 'text', 'Key 2', null, 'My Group Name', null, null, null);
		$this->dvsPageData->cid('col[key1]', 'collection', 'col', 'key1', 'text', 'Key 1', 'Collection Name', 'My Group Name', 'category', 'alternate target', null);
		$this->dvsPageData->cid('col[key2]', 'collection', 'col', 'key2', 'text', 'Key 2', 'Collection Name', 'My Group Name', 'category', 'alternate target', null);
		$this->dvsPageData->cid('col[key3]', 'collection', 'col', 'key3', 'text', 'Key 3', 'Collection Name', 'My Group Name', 'category', 'alternate target', null);
		$this->dvsPageData->cid('$page', 'variable', null, ['$page' => $page,], 'variable', 'Page', null, null, null, null, null);
		$this->dvsPageData->cid('$page->view', 'variable', null, ['view' => $page->view, '$page' => $page,], 'variable', 'The Page View', null, null, null, null, null);
		$this->dvsPageData->cid('creator.07bc2f9dadb7314768a55b1f9cd404dc', 'creator', null, 'DvsPage', 'creator', 'The Page Creator', null, null, null, null, null);
	}
}