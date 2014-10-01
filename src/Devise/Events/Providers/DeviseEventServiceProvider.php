<?php namespace Devise\Events\Providers;

use Devise\Events\DeviseEvent;
use Illuminate\Support\ServiceProvider;

class DeviseEventServiceProvider extends ServiceProvider {

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
    public function boot(){}

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('deviseevent', function($app)
        {
            return new DeviseEvent($app);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('deviseevent');
    }
}
