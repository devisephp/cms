<?php namespace Devise\Sidebar;

use Mockery as m;

class SidebarServiceProviderTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
        $app = m::mock('Illuminate\Container\Container');
        new SidebarServiceProvider($app);
    }
}