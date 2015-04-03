<?php namespace Devise\Pages;

use Mockery as m;

class PagesServiceProviderTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
        $app = m::mock('Illuminate\Container\Container');
        new PagesServiceProvider($app);
    }
}
