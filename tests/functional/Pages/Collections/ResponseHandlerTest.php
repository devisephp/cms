<?php namespace Devise\Pages\Collections;

use Mockery as m;

class ResponseHandlerTest extends \DeviseTestCase
{
	public function setUp()
	{
		parent::setUp();

		$this->CollectionsManager = m::mock('Devise\Pages\Collections\CollectionsManager');
		$this->ResponseHandler = new ResponseHandler($this->CollectionsManager);
	}

	public function test_it_updates_field()
	{
		$this->markTestIncomplete();
	}

	public function test_it_stores_instance()
	{
		$this->CollectionsManager->shouldReceive('createNewInstance')->times(1);
		$this->ResponseHandler->requestStoreInstance(1, 1, ['sort' => 4, 'name' => 'some instance']);
	}

	public function test_it_updates_sort_order()
	{
		$this->CollectionsManager->shouldReceive('updateInstanceSort')->times(3);
		$this->ResponseHandler->updateSortOrder(1, 1, ['instance' => [['id' => 1], ['id' => 2], ['id' => 3]]]);
	}

	public function test_it_renames_instance()
	{
		$this->CollectionsManager->shouldReceive('updateInstanceName')->times(1);
		$this->ResponseHandler->renameInstance(1, 1, ['name' => 'some new name']);
	}

	public function test_it_deletes_instance()
	{
		$this->CollectionsManager->shouldReceive('removeInstance')->times(1);
		$this->ResponseHandler->requestDeleteInstance(1);
	}
}