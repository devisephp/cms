<?php namespace Devise\Support\Sortable;

use Mockery as m;

class SortableServiceProviderTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
        $app = m::mock('Illuminate\Container\Container');
        new SortableServiceProvider($app);
    }
}