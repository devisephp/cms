<?php namespace Devise\Search;

use Mockery as m;

class UniversalSearchTest extends \DeviseTestCase
{
	public function setUp()
	{
        parent::setUp();
		$this->search = new UniversalSearch(new Pagination);
	}

	public function test_it_can_register_an_item()
	{
		$item = m::mock('Devise\Search\Searchable');
		$this->search->register($item);
	}

	public function test_it_can_search_thru_items()
	{
        $mockedResult = new MockedSearchResult;
        $item1 = m::mock('Devise\Search\Searchable');
        $item1->shouldReceive('search')->andReturn($mockedResult);

        $this->search->register($item1);
		$outcome = $this->search->search('asdf');

		assertInstanceOf('Devise\Search\Pagination', $outcome);
		assertCount(1, $outcome->toArray()['items']);
	}
}

class MockedSearchResult
{
	public $searchableType = 'Devise\Search\MockSearcher';

	public function search($for) { return $this; }
	public function take($number) { return $this; }
	public function get(){ return $this; }
	public function merge() { return $this; }
	public function count() { return 1; }
	public function skip() { return $this; }
	public function sortByDesc() { return $this; }
	public function slice() { return [$this]; }
}
