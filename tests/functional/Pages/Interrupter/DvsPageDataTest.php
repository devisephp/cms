<?php namespace Devise\Pages\Interrupter;

class DvsPageDataTest extends \DeviseTestCase
{
	public function setUp()
	{
		parent::setUp();
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

	public function test_it_can_add_models()
	{
		$model = \DvsPage::find(1);

		assertEquals([
			'cid' => "model0",
			'key' => "1",
			'table' => "dvs_pages",
			'class' => "DvsPage",
			'humanName' => "Human Name",
			'collection' => null,
		], $this->dvsPageData->addModel($model, 'Human Name', null));
	}

	public function test_it_can_add_model_attributes()
	{
		$model = \DvsPage::find(1);

		assertEquals([
			'cid' => "attribute0",
			'key' => "1",
			'table' => "dvs_pages",
			'class' => "DvsPage",
			'humanName' => "Human Name",
			'collection' => null,
			'attribute' => 'title',
		], $this->dvsPageData->addModelAttribute($model, 'title', 'Human Name', null));
	}

	public function test_it_can_add_model_creators()
	{
		$this->dvsPageData->addModelCreator('cid123', 'DvsUser', "Human name");

		assertEquals('[{"cid":"cid123","model_name":"DvsUser","human_name":"Human name"}]', $this->dvsPageData->modelCreatorsJSON());
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