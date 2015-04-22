<?php namespace Devise\Pages\Collections;

class CollectionsManagerTest extends \DeviseTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->CollectionInstance = new \DvsCollectionInstance;
		$this->Field = new \DvsField;
		$this->CollectionsManager = new CollectionsManager($this->CollectionInstance, $this->Field);
	}

	public function test_it_creates_new_instance()
	{
		$previous = $this->CollectionInstance->count();
		$this->CollectionsManager->createNewInstance([
			'page_version_id' => 1,
			'collection_set_id' => 1,
			'name' => 'My New Instance',
			'sort' => 3,
		]);
		$current = $this->CollectionInstance->count();
		assertEquals($previous, $current - 1);
	}

	public function test_it_creates_new_instance_field()
	{
		$previous = $this->Field->count();
		$instance = $this->CollectionInstance->find(1);
		$fieldInput = ['type' => 'text', 'key' => 'key', 'human_name' => 'human name'];
		$this->CollectionsManager->createNewInstanceField($instance, $fieldInput);
		$current = $this->Field->count();
		assertEquals($previous, $current - 1);
	}

	public function test_it_updates_instance_sort()
	{
		$this->CollectionsManager->updateInstanceSort(1, 3);
		assertEquals(3, $this->CollectionInstance->find(1)->sort);
	}

	public function test_it_updates_instance_name()
	{
		$this->CollectionsManager->updateInstanceName(1, 'Updated Instance Name');
		assertEquals('Updated Instance Name', $this->CollectionInstance->find(1)->name);
	}

	public function test_it_removes_instance()
	{
		$previous = $this->CollectionInstance->count();
		$this->CollectionsManager->removeInstance(1);
		$current = $this->CollectionInstance->count();
		assertEquals($previous - 1, $current);
	}
}