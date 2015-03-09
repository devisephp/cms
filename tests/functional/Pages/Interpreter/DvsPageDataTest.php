<?php namespace Devise\Pages\Interpreter;

class DvsPageDataTest extends \DeviseTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->dvsPageData = new DvsPageData;
	}

	public function test_it_registers_tags()
	{
		$this->dvsPageData->register('col[key1]', 'collection', 'col', 'key1', 'text', 'Key 1', 'group', 'category', 'alternate target');
	}

	/**
	 * @expectedException Devise\Pages\Interpreter\Exceptions\DuplicateDeviseKeyException
	 */
	public function test_it_cannot_register_a_key_more_than_once()
	{
		$this->dvsPageData->register('key1', 'field', null, 'key1', 'text', 'Key 1', null, null, null);
		$this->dvsPageData->register('key1', 'field', null, 'key1', 'text', 'Key 1', null, null, null);
	}

	public function test_it_can_set_defaults()
	{
		$defaults = ['durka' => 'stuff'];
		$this->dvsPageData->register('key1', 'field', null, 'key1', 'text', 'Key 1', null, null, null);
		$this->dvsPageData->setDefaults('key1', $defaults);
		$tags = $this->dvsPageData->tags();
		assertEquals($defaults, $tags['key1']['defaults']);
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
		$this->dvsPageData->register('key1', 'field', null, 'key1', 'text', 'Key 1', null, null, null);
		$cid = $this->dvsPageData->cid('key1', 'field', null, 'key1', 'text', 'Key 1', null, null, null, null);
		assertEquals('field0', $cid);
	}

	public function test_it_can_give_us_cid_for_collection_tag()
	{
		$this->dvsPageData->register('col[key1]', 'collection', 'col', 'key1', 'text', 'Key 1', null, null, null);
		$cid = $this->dvsPageData->cid('col[key1]', 'collection', 'col', 'key1', 'text', 'Key 1', null, null, null, null);
		assertEquals('collection0', $cid);
	}

	public function test_it_can_give_us_cid_for_model_tag()
	{
		$model = \DvsPage::find(1);
		$this->dvsPageData->register('$model', 'variable', null, '$model', 'variable', 'Model', null, null, null);
		$cid = $this->dvsPageData->cid('$model', 'variable', null, ['$model' => $model,], 'variable', 'Model', null, null, null, null);
		assertEquals('model0', $cid);
	}

	public function test_it_can_give_us_cid_for_model_attribute_tag()
	{
		$page = \DvsPage::find(1);
		$this->dvsPageData->register('$page->view', 'variable', null, '$page->view', 'variable', 'The Page View', null, null, null);
		$cid = $this->dvsPageData->cid('$page->view', "variable", null, ['view' => $page->view,'$page' => $page,], "variable", "The Page View", null, null, null, null);
		assertEquals('attribute0', $cid);
	}

	public function test_it_can_give_us_cid_for_model_creator_tag()
	{
		$this->dvsPageData->register('creator.07bc2f9dadb7314768a55b1f9cd404dc', 'creator', null, 'DvsPage', 'creator', 'The Page Creator', null, null, null);
		$cid = $this->dvsPageData->cid('creator.07bc2f9dadb7314768a55b1f9cd404dc', "creator", null, "DvsPage", "creator", "The Page Creator", null, null, null, null);
		assertEquals('creator0', $cid);
	}

	public function test_it_gives_us_collections_json()
	{
		$this->populateDvsPageData();
		$json = $this->dvsPageData->collectionsJSON();
		assertEquals('{"col":[{"tid":"col[key1]","cid":"collection0","collection":"col","key":"key1","type":"text","humanName":"Key 1","group":"group","category":"category","alternateTarget":"alternate target","defaults":null},{"tid":"col[key2]","cid":"collection1","collection":"col","key":"key2","type":"text","humanName":"Key 2","group":"group","category":"category","alternateTarget":"alternate target","defaults":null},{"tid":"col[key3]","cid":"collection2","collection":"col","key":"key3","type":"text","humanName":"Key 3","group":"group","category":"category","alternateTarget":"alternate target","defaults":null}]}', $json);
	}

	public function test_it_gives_us_fields_json()
	{
		$this->populateDvsPageData();
		$json = $this->dvsPageData->fieldsJSON();
		assertEquals('[{"tid":"key1","cid":"field0","key":"key1","type":"text","humanName":"Key 1","group":null,"category":null,"alternateTarget":null,"defaults":null},{"tid":"key2","cid":"field1","key":"key2","type":"text","humanName":"Key 2","group":null,"category":null,"alternateTarget":null,"defaults":null}]', $json);
	}

	public function test_it_gives_us_models_json()
	{
		$this->populateDvsPageData();
		$json = $this->dvsPageData->modelsJSON();
		assertEquals('[{"tid":"$page","cid":"model0","key":"1","table":"dvs_pages","class":"DvsPage","humanName":"Page","collection":null}]', $json);
	}

	public function test_it_gives_us_model_attributes_json()
	{
		$this->populateDvsPageData();
		$json = $this->dvsPageData->modelAttributesJSON();
		assertEquals('[{"tid":"$page->view","cid":"attribute0","key":"1","table":"dvs_pages","class":"DvsPage","humanName":"The Page View","collection":null,"attribute":"view"}]', $json);
	}

	public function test_it_gives_us_model_creators_json()
	{
		$this->populateDvsPageData();
		$json = $this->dvsPageData->modelCreatorsJSON();
		assertEquals('[{"tid":"creator.07bc2f9dadb7314768a55b1f9cd404dc","cid":"creator0","model_name":"DvsPage","human_name":"The Page Creator"}]', $json);
	}

	private function populateDvsPageData()
	{
		$page = \DvsPage::find(1);

		$this->dvsPageData->register('key1', 'field', null, 'key1', 'text', 'Key 1', null, null, null);
		$this->dvsPageData->register('key2', 'field', null, 'key2', 'text', 'Key 2', null, null, null);
		$this->dvsPageData->register('col[key1]', 'collection', 'col', 'key1', 'text', 'Key 1', 'group', 'category', 'alternate target');
		$this->dvsPageData->register('col[key2]', 'collection', 'col', 'key2', 'text', 'Key 2', 'group', 'category', 'alternate target');
		$this->dvsPageData->register('col[key3]', 'collection', 'col', 'key3', 'text', 'Key 3', 'group', 'category', 'alternate target');
		$this->dvsPageData->register('$page', 'variable', null, '$page', 'variable', 'Page', null, null, null);
		$this->dvsPageData->register('$page->view', 'variable', null, '$page->view', 'variable', 'The Page View', null, null, null);
		$this->dvsPageData->register('creator.07bc2f9dadb7314768a55b1f9cd404dc', 'creator', null, 'DvsPage', 'creator', 'The Page Creator', null, null, null);

		$this->dvsPageData->cid('key1', 'field', null, 'key1', 'text', 'Key 1', null, null, null, null);
		$this->dvsPageData->cid('key2', 'field', null, 'key2', 'text', 'Key 2', null, null, null, null);
		$this->dvsPageData->cid('col[key1]', 'collection', 'col', 'key1', 'text', 'Key 1', 'group', 'category', 'alternate target', null);
		$this->dvsPageData->cid('col[key2]', 'collection', 'col', 'key2', 'text', 'Key 2', 'group', 'category', 'alternate target', null);
		$this->dvsPageData->cid('col[key3]', 'collection', 'col', 'key3', 'text', 'Key 3', 'group', 'category', 'alternate target', null);
		$this->dvsPageData->cid('$page', 'variable', null, ['$page' => $page,], 'variable', 'Page', null, null, null, null);
		$this->dvsPageData->cid('$page->view', 'variable', null, ['view' => $page->view, '$page' => $page,], 'variable', 'The Page View', null, null, null, null);
		$this->dvsPageData->cid('creator.07bc2f9dadb7314768a55b1f9cd404dc', 'creator', null, 'DvsPage', 'creator', 'The Page Creator', null, null, null, null);
	}
}