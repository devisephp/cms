<?php namespace Devise\Search;

/**
 * Class DeviseUniversalSearchProvider registers the universal
 * searching mechanism for Devise
 *
 * @package Devise\Search
 */
class UniversalSearchProvider extends \Illuminate\Support\ServiceProvider
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
        $search = new UniversalSearch(new Pagination);
        $this->app->instance("DeviseUniversalSearch", $search);
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
