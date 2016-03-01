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
		$this->TagManager->shouldReceive('getInstanceForTag')->once()->andReturn('data');
		$this->dvsPageData->register('col[key1]', 'collection', 'col', 'key1', 'text', 'Key 1', 'collection name', 'group', 'category', 'alternate target');
	}

	/**
	 * @expectedException Devise\Pages\Interpreter\Exceptions\DuplicateDeviseKeyException
	 */
	public function test_it_cannot_register_a_key_more_than_once()
	{
		$this->TagManager->shouldReceive('getInstanceForTag')->andReturn('data');
		$this->dvsPageData->register('key1', 'field', null, 'key1', 'text', 'Key 1', null, null, null, null);
		$this->dvsPageData->register('key1', 'field', null, 'key1', 'text', 'Key 1', null, null, null, null);
	}

	public function test_it_can_set_defaults()
	{
		$defaults = ['durka' => 'stuff'];
		$this->TagManager->shouldReceive('getInstanceForTag')->andReturn('data');
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
		$this->TagManager->shouldReceive('getInstanceForTag')->twice()->andReturn($dvsField);
		$this->dvsPageData->register('key1', 'field', null, 'key1', 'text', 'Key 1', null, null, null, null);
		$cid = $this->dvsPageData->cid('key1', 'field', null, 'key1', 'text', 'Key 1', null, null, null, null, null);
		assertEquals('field42', $cid);
	}

	public function test_it_can_give_us_cid_for_collection_tag()
	{
		$dvsField = new \DvsField; $dvsField->id = 42;
		$this->TagManager->shouldReceive('getInstanceForTag')->twice()->andReturn($dvsField);
		$this->dvsPageData->register('col[key1]', 'collection', 'col', 'key1', 'text', 'Key 1', null, null, null, null);
		$cid = $this->dvsPageData->cid('col[key1]', 'collection', 'col', 'key1', 'text', 'Key 1', null, null, null, null, null);
		assertEquals('collection42', $cid);
	}

	public function test_it_can_give_us_cid_for_model_tag()
	{
		$model = \DvsPage::find(1);
		$dvsField = new \DvsField; $dvsField->id = 42;
		$this->TagManager->shouldReceive('getInstanceForTag')->twice()->andReturn($dvsField);
		$this->dvsPageData->register('$model', 'variable', null, '$model', 'variable', 'Model', null, null, null, null);
		$cid = $this->dvsPageData->cid('$model', 'variable', null, ['$model' => $model,], 'variable', 'Model', null, null, null, null, null);
		assertEquals('model0', $cid);
	}

	public function test_it_can_give_us_cid_for_model_attribute_tag()
	{
		$page = \DvsPage::find(1);
		$dvsField = new \DvsField; $dvsField->id = 42;
		$this->TagManager->shouldReceive('getInstanceForTag')->twice()->andReturn($dvsField);
		$this->dvsPageData->register('$page->view', 'variable', null, '$page->view', 'variable', 'The Page View', null, null, null, null);
		$cid = $this->dvsPageData->cid('$page->view', "variable", null, ['view' => $page->view,'$page' => $page,], "variable", "The Page View", null, null, null, null, null);
		assertEquals('attribute42', $cid);
	}

	public function test_it_can_give_us_cid_for_model_creator_tag()
	{
		$dvsField = new \StdClass; $dvsField->id = 42;
		$this->TagManager->shouldReceive('getInstanceForTag')->twice()->andReturn($dvsField);
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
		$this->CollectionsRepository->shouldReceive('syncFieldsForInstances')->once()->andReturn([]);
		$this->TagManager->shouldReceive('getInstanceForTag')->andReturn($dvsField);
		$this->populateDvsPageData();
		$json = $this->dvsPageData->toJSON();
		assertContains('{"cid":"group0","key":"group0","binding":"group","human_name":"My Group Name","position":{"top":0,"left":0,"side":"left"},"data":{"categories":[{"id":0,"name":"Uncategorized","nodes":[{"cid":"field42","key":"key2","binding":"field","human_name":"Key 2","position":{"top":0,"left":0,"side":"left"},"data":{"id":42}}]},{"id":1,"name":"category","nodes":[{"cid":"collection42","key":"col","binding":"collection","human_name":"Collection Name","position":{"top":0,"left":0,"side":"left"},"schema":[{"id":"col[key1]","cid":"collection42","bindingType":"collection","collection":"col","key":"key1","type":"text","humanName":"Key 1","collectionName":"Collection Name","group":"My Group Name","category":"category","alternateTarget":"alternate target","defaults":null,"hidden":true,"data":{"id":42}},{"id":"col[key2]","cid":"collection42","bindingType":"collection","collection":"col","key":"key2","type":"text","humanName":"Key 2","collectionName":"Collection Name","group":"My Group Name","category":"category","alternateTarget":"alternate target","defaults":null,"hidden":true,"data":{"id":42}},{"id":"col[key3]","cid":"collection42","bindingType":"collection","collection":"col","key":"key3","type":"text","humanName":"Key 3","collectionName":"Collection Name","group":"My Group Name","category":"category","alternateTarget":"alternate target","defaults":null,"hidden":true,"data":{"id":42}}],"collection":{"id":42},"data":[]}', $json);
		assertContains('{"cid":"field42","key":"key1","binding":"field","human_name":"Key 1","position":{"top":0,"left":0,"side":"left"},"data":{"id":42}},', $json);
		assertContains('{"cid":"model0","key":"$page","binding":"model","human_name":"Page","position":{"top":0,"left":0,"side":"left"},"data":{"id":42},"model":{"id":1,"language_id":"45","translated_from_page_id":"0","view":"devise::admin.pages.index","title":"Manage Pages","http_verb":"get","route_name":"dvs-pages","is_admin":"1","dvs_admin":"1","slug":"\/admin\/pages","short_description":"Allows the management of devise pages","meta_title":null,"meta_description":null,"meta_keywords":null,"head":null,"footer":null,"before":"ifNotLoggedInGoToLogin","after":"","response_type":"View","response_path":null,"response_params":null,"created_at":', $json);
		assertContains('{"cid":"attribute42","key":"$page->view","binding":"attribute","human_name":"The Page View","position":{"top":0,"left":0,"side":"left"},"data":{"id":42},"model":{"id":1,"language_id":"45","translated_from_page_id":"0","view":"devise::admin.pages.index","title":"Manage Pages","http_verb":"get","route_name":"dvs-pages","is_admin":"1","dvs_admin":"1","slug":"\/admin\/pages","short_description":"Allows the management of devise pages","meta_title":null,"meta_description":null,"meta_keywords":null,"head":null,"footer":null,"before":"ifNotLoggedInGoToLogin","after":"","response_type":"View","response_path":null,"response_params":null,"created_at":"', $json);
		assertContains('{"cid":"creator42","key":"creator.07bc2f9dadb7314768a55b1f9cd404dc","binding":"creator","human_name":"The Page Creator","position":{"top":0,"left":0,"side":"left"},"data":{"id":42}},', $json);
		assertContains('"pageId":1,"pageVersionId":1,"languageId":45,"csrfToken":', $json);
		assertContains('"availableLanguages":{"en":"EN"},"pageRoutes":["route1","route2"],"pageVersions":["version1","version2"],"database":[]}', $json);
	}

	public function test_it_can_set_database_key_value_pairs()
	{
		$this->dvsPageData->database('key1', 'value1');
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