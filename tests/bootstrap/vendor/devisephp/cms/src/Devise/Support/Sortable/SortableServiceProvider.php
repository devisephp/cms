<?php namespace Devise\Support\Sortable;

use Devise\Support\Framework;
use Illuminate\Support\ServiceProvider;

/**
 * Class SortableServiceProvider registers the Sort facade
 * on the Laravel container
 *
 * @package Devise\Support\Sortable
 */
class SortableServiceProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('devisesort', function($app)
        {
            $Framework = new Framework;
            return new Sort(new Manager($Framework), $Framework);
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
        return array('devisesort');
	}
}