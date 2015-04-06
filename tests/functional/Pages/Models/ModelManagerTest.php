<?php namespace Devise\Pages\Models;

class ModelManagerTest extends \DeviseTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->DvsModelField = new \DvsModelField;
		$this->Framework = new \Devise\Support\Framework;
		$this->ModelManager = new ModelManager($this->DvsModelField, $this->Framework);
	}
	public function test_it_updates_fields()
	{
		$this->addSomeTestModelFields();
		$fields = [
			['id' => 1, 'model_id' => 1, 'model_type' => 'DvsTestModel', 'mapping' => 'Name', 'json_value' => '{}', 'values' => [ 'foo' => 'bar', 'durka' => 'scratch scratch' ] ]
		];
		$page = ['page_version_id' => 1, 'page_id' => 42, 'language_id' => 45];
		$this->ModelManager->updateFields($fields, $page);
	}

	protected function addSomeTestModelFields()
	{
		\DB::table('dvs_model_fields')->insert(['id' => 1, 'model_id' => 1, 'model_type' => 'DvsTestModel', 'mapping' => 'Name', 'json_value' => '{}' ]);
	}
}