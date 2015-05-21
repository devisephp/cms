<?php namespace Devise\Pages\Collections;

use Mockery as m;

class CollectionsRepositoryTest extends \DeviseTestCase
{
	public function setUp()
	{
		parent::setUp();

		$this->CollectionFieldsFactory = m::mock('Devise\Pages\Collections\CollectionFieldsFactory');

		$this->CollectionsRepository = new CollectionsRepository(
			new \DvsCollectionInstance,
			new \DvsCollectionSet,
			new \DvsField,
			new \DvsPageVersion,
			$this->CollectionFieldsFactory
		);
	}

	public function test_it_gets_instances()
	{
		$output = $this->CollectionsRepository->getInstances(1, 1);
		assertNotCount(0, $output);
	}

	public function test_it_finds_collections_for_page_version_id()
	{
		$this->CollectionFieldsFactory->shouldReceive('createFromCollectionInstance')->times(2);
		$output = $this->CollectionsRepository->findCollectionsForPageVersionId(1);
	}

	public function test_it_finds_collections_for_page_version()
	{
		$this->CollectionFieldsFactory->shouldReceive('createFromCollectionInstance')->times(2);
		$output = $this->CollectionsRepository->findCollectionsForPageVersion(\DvsPageVersion::find(1));
	}

	public function test_it_finds_collection_instances_for_collection_set_id_and_page_version_id()
	{
		$output = $this->CollectionsRepository->findCollectionInstancesForCollectionSetIdAndPageVersionId(1, 1);
		assertNotCount(0, $output);
	}
}