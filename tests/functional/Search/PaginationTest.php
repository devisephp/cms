<?php namespace Devise\Search;

use Mockery as m;

class PaginationTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->Pagination = new Pagination;
    }

    public function test_it_makes()
    {
        $this->makePaginator($page = 1, $perPage = 10);
    }

    public function test_it_links()
    {
        $paginator = $this->makePaginator(1, 10);
        $paginator->View = m::mock('MyView');
        $paginator->View->shouldReceive('make')->times(1)->andReturnSelf();
        $paginator->View->shouldReceive('render')->times(1)->andReturnSelf();
        $paginator->links();
    }

    public function test_it_turns_into_array()
    {
        $paginator = $this->makePaginator(1, 10);
        $paginator->toArray();
    }

    public function test_it_can_append()
    {
        $paginator = $this->makePaginator(1, 10);
        $paginator->appends(['some' => 'data']);
    }

    public function test_it_can_be_iterated_over()
    {
        $paginator = $this->makePaginator(1, 10);
        $paginator->getIterator();
    }

    public function test_it_can_be_converted_to_json()
    {
        $paginator = $this->makePaginator(1, 10);
        $paginator->toJson();
    }

    protected function makePaginator($page, $perPage)
    {
        $collection = m::mock('Collection');
        $items = m::mock('ArrayAccess');
        $items->shouldReceive('offsetGet')->andReturnSelf();
        $items->searchableType = 'searchableType';
        $items->shouldReceive('getIterator');
        $items->shouldReceive('toJSON')->andReturn('{}');
        $collection->shouldReceive('count')->times(1)->andReturn(10);
        $collection->shouldReceive('slice')->times(1)->andReturn($items);
        return $this->Pagination->make($collection, $page = 1, $perPage = 10);
    }
}