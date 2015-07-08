<?php namespace Devise\Pages;

use Illuminate\Foundation\Console\RouteCacheCommand;

class RoutesCacheCommand extends RouteCacheCommand
{
	public function error($string)
	{
		// do nothing...
	}

	public function info($string)
	{
		// do nothing...
	}

    public function fire()
    {
		\App::make('Illuminate\Foundation\Console\RouteCacheCommand')->fire();
    }
}