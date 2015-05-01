<?php namespace Devise\Pages;

use Mockery as m;

class PageVersionsRepositoryTest extends \DeviseTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->PageVersionsRepository = new PageVersionsRepository(new \DvsPageVersion);
	}

	public function test_it_gets_unscheduled_page_versions()
	{
		assertCount(0, $this->PageVersionsRepository->getUnscheduledPageVersions());
	}
}