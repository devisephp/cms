<?php namespace Devise\Support;

use Mockery as m;

class SupportServiceProviderTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
        $app = m::mock('Illuminate\Container\Container');
        new SupportServiceProvider($app);
    }
}