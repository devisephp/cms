<?php namespace Devise\Support;

use Illuminate\Support\ServiceProvider;

/**
 * Class SupportServiceProvider registers support components of
 * Devise and other helpers that Devise uses.
 *
 * @package Devise\Support
 */
class SupportServiceProvider extends ServiceProvider
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
		$this->package('lbm/devise-support');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->registerSortable();
        $this->app->instance('Framework', function()
        {
            return new \Devise\Support\Framework;
        });
	}

    /**
     * Register the sortable facade and provider for
     * Sort helper in devise
     *
     * @return void
     */
    private function registerSortable()
    {
        $provider = new Sortable\SortableServiceProvider($this->app);
        $this->app->register($provider);
        $provider->boot();
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}
}
