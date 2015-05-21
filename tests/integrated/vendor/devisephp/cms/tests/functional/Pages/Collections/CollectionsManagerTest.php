<?php namespace Devise\Pages\Collections;

class CollectionsManagerTest extends \DeviseTestCase
{
	public function setUp()
	{
		parent::setUp();

		$this->CollectionInstance = new \DvsCollectionInstance;
		$this->CollectionsManager = new CollectionsManager($this->CollectionInstance);
	}

	public function test_it_creates_new_instance()
	{
		// given the count is some number
		$previous = $this->CollectionInstance->count();

		// when we create a new instance
		$this->CollectionsManager->createNewInstance([
			'page_version_id' => 1,
			'collection_set_id' => 1,
			'name' => 'My New Instance',
			'sort' => 3,
		]);

		// then we should see one more instance
		$current = $this->CollectionInstance->count();
		assertEquals($previous, $current - 1);
	}

	public function test_it_updates_instance()
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
		// given the count of instances is some number
		$previous = $this->CollectionInstance->count();

		// when we remove an instance
		$this->CollectionsManager->removeInstance(1);

		// then we have one less instance in the database
		$current = $this->CollectionInstance->count();
		assertEquals($previous - 1, $current);
	}
}