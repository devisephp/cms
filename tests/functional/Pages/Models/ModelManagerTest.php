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

	public function test_it_creates_fields()
	{
		$page = ['page_version_id' => 50, 'page_id' => 42, 'language_id' => 45];
		$fields = [['id' => 'Name', 'model_type' => 'DvsTestModel', 'mapping' => 'Name', 'values' => [ 'text' => 'the name here' ] ] ];
		$previousFieldCount = \DvsModelField::count();
		$previousModelCount = \DvsTestModel::count();
		list ($createdFields, $createdModel) = $this->ModelManager->createFieldsAndModel($fields, $page);
		$modelField = \DvsModelField::find($createdFields[0]->id);
		$model = $modelField->model;
		assertCount(1, $createdFields);
		assertEquals($createdModel->id, $model->id);
		assertEquals(50, $model->page_version_id);
		assertEquals('the name here', $model->name);
		assertEquals($previousFieldCount + 1, \DvsModelField::count());
		assertEquals($previousModelCount + 1, \DvsTestModel::count());
	}

	public function test_it_validates_fields_on_create()
	{
		$page = ['page_version_id' => 50, 'page_id' => 42, 'language_id' => 45];
		$fields = [['id' => 'Name', 'model_type' => 'DvsTestModel', 'mapping' => 'Name', 'values' => [ 'text' => '' ] ] ];
		$previousFieldCount = \DvsModelField::count();
		$previousModelCount = \DvsTestModel::count();

		try
		{
			list ($createdFields, $createdModel) = $this->ModelManager->createFieldsAndModel($fields, $page);
		}

		catch (ModelFieldValidationFailedException $e)
		{
			// make sure we don't end up with leftover crap in db
			assertEquals($previousFieldCount, \DvsModelField::count());
			assertEquals($previousModelCount, \DvsTestModel::count());
			assertInstanceOf('Illuminate\Support\MessageBag', $e->getErrors());
			assertEquals('The name field is required.', $e->getErrors()->first('name'));
			return;
		}

		throw new \Exception("This line should not execute unless a ModelFieldValidationFailedException was not thrown");
	}

	public function test_it_validates_fields_on_update()
	{
		$page = ['page_version_id' => 50, 'page_id' => 42, 'language_id' => 45];
		$fields = [['id' => 1, 'model_id' => 1, 'model_type' => 'DvsTestModel', 'mapping' => 'Name', 'json_value' => '{}', 'values' => [ 'foo' => 'bar' ] ]];
		$this->addSomeTestModelFields();

		try
		{
			$this->ModelManager->updateFields($fields, $page);
		}
		catch (ModelFieldValidationFailedException $e)
		{
			$field = \DvsModelField::find(1);
			$model = \DvsTestModel::find(1);

			assertEquals(1, $model->page_version_id);
			assertEquals('Some name here', $model->name);
			assertEquals('{}', $field->json_value);
			assertInstanceOf('Illuminate\Support\MessageBag', $e->getErrors());
			assertEquals('The name field is required.', $e->getErrors()->first('name'));

			return;
		}

		throw new \Exception("We should not reach this line unless the model validation exception was not thrown...");
	}

	public function test_it_updates_fields()
	{
		$page = ['page_version_id' => 50, 'page_id' => 42, 'language_id' => 45];
		$fields = [['id' => 1, 'model_id' => 1, 'model_type' => 'DvsTestModel', 'mapping' => 'Name', 'json_value' => '{}', 'values' => [ 'text' => 'bar' ] ]];
		$this->addSomeTestModelFields();
		$this->ModelManager->updateFields($fields, $page);
		$fields = \DB::table('dvs_model_fields')->where('model_type', '=', 'DvsTestModel')->get();
		$model = \DvsTestModel::find(1);
		assertEquals(50, $model->page_version_id);
		assertEquals('bar', $model->name);
		assertEquals('{"text":"bar"}', $fields[0]->json_value);
	}

	protected function addSomeTestModelFields()
	{
		\DB::table('dvs_model_fields')->insert(['id' => 1, 'model_id' => 1, 'model_type' => 'DvsTestModel', 'mapping' => 'Name', 'json_value' => '{}' ]);
	}
}