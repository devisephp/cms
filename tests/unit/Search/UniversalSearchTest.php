<?php namespace Devise\Search;

class UniversalSearchTest extends \DeviseTestCase
{
	public function setUp()
	{
		$this->search = new UniversalSearch;
	}

	public function test_it_can_register_an_item()
	{
		$item = $this->getMock('Devise\Search\Searchable');
		$this->search->register($item);
	}

	public function test_it_can_search_thru_items()
	{
		$item = $this->getMock('Devise\Search\Searchable');

		$item->expects($this->exactly(3))
			->method('search')
			->with($this->equalTo('asdf'))
			->will($this->returnValue(['thing']));

		$this->search->register($item);
		$this->search->register($item);
		$this->search->register($item);

		$outcome = $this->search->search('asdf');

		assertEquals(['thing', 'thing', 'thing'], $outcome);
	}
}