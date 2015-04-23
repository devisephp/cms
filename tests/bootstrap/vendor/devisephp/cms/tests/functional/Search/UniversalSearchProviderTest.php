<?php namespace Devise\Search;

use Mockery as m;

class UniversalSearchProviderTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
        $app = m::mock('Illuminate\Container\Container');
        new UniversalSearchProvider($app);
    }
}