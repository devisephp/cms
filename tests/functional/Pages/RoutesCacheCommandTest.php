<?php namespace Devise\Pages;

use Devise\Support\Framework;

class RoutesCacheCommandTest extends \DeviseTestCase
{
    public function test_it_can_fire()
    {
    	// we rely on laravel here,
    	// so I'm not going to test this
    	// we will make sure that the class
    	// can at least compile but other
    	// than that it is Laravel's hands

    	$Framework = new Framework;
    	new RoutesCacheCommand($Framework->File);
    }

    public function test_it_has_empty_info()
    {
    	$Framework = new Framework;
    	$RoutesCacheCommand = new RoutesCacheCommand($Framework->File);
    	$RoutesCacheCommand->info("");
    }

    public function test_it_has_empty_error()
    {
    	$Framework = new Framework;
    	$RoutesCacheCommand = new RoutesCacheCommand($Framework->File);
    	$RoutesCacheCommand->error("");
    }
}