<?php namespace Devise\Support\Sortable;

use Mockery as m;

class EloquentBuilderTest extends \DeviseTestCase
{
    public function test_it_uses_sorting_and_filtering()
    {
        // all these mocks are just to keep Eloquent satisfied
        $BuilderMock = m::mock('Illuminate\Database\Query\Builder');
        $EloquentBuilder = new EloquentBuilder($BuilderMock);
        $BuilderMock->shouldReceive('getCountForPagination')->andReturn(10);
        $BuilderMock->shouldReceive('forPage')->andReturnSelf();
        $BuilderMock->shouldReceive('from')->andReturnSelf();
        $BuilderMock->shouldReceive('get')->andReturnSelf();

        $ModelMock = m::mock('Illuminate\Database\Eloquent\Model');
        $ModelMock->shouldReceive('toArray')->andReturn([]);
        $ModelMock->shouldReceive('getTable')->andReturnSelf();
        $ModelMock->shouldReceive('getConnectionName')->andReturnSelf();
        $ModelMock->shouldReceive('newFromBuilder')->andReturnSelf();
        $ModelMock->shouldReceive('setConnection')->andReturnSelf();
        $ModelMock->shouldReceive('newCollection')->andReturnSelf();
        $ModelMock->shouldReceive('all')->andReturnSelf();
        $EloquentBuilder->setModel($ModelMock);

        // these are the real mocks we care about, we want to
        // ensure that they are called once when we try to
        // paginate a laravel model
        \Sort::shouldReceive('handleSorting')->times(1);
        \Sort::shouldReceive('handleFiltering')->times(1);

        $EloquentBuilder->paginate(10);
    }
}