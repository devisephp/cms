<?php namespace Devise\Support\Sortable;

use Mockery as m;

class EloquentBuilderTest extends \DeviseTestCase
{
    public function test_it_uses_sorting_and_filtering()
    {
        $BuilderMock = m::mock('Illuminate\Database\Query\Builder');
        $EloquentBuilder = m::mock('Devise\Support\Sortable\EloquentBuilder[callParentPagination]', [$BuilderMock])->shouldAllowMockingProtectedMethods();
        $EloquentBuilder->shouldReceive('callParentPagination')->once()->andReturn('asdf');

        \Sort::shouldReceive('handleSorting')->times(1);
        \Sort::shouldReceive('handleFiltering')->times(1);

        $EloquentBuilder->paginate(10);
    }
}