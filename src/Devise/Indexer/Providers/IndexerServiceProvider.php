<?php namespace Devise\Indexer\Providers;

use Devise\Indexer\DeviseIndexer;
use Illuminate\Support\ServiceProvider;

class IndexerServiceProvider extends ServiceProvider {

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
        include __DIR__.'/../routes.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //bind 'deviseindexer' for the facade
        $this->app->bind('deviseindexer', function($app)
        {
            return new DeviseIndexer($app);
        });
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
