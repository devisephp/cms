<?php namespace Devise\Data\Providers;

use Devise\Data\DeviseData;
use Devise\Data\Security\FormEncrypt;
use Illuminate\Support\ServiceProvider;
use Event;

class DataServiceProvider extends ServiceProvider {

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
        $this->registerFormEvents();

        //bind 'devisedata' for facade
        $this->app->bind('devisedata', function($app)
        {
            return new DeviseData($app);
        });
    }

    /**
     * Register form events
     *
     * @return void
     */
    public function registerFormEvents()
    {
        Event::listen('form.open', function($options)
        {
            FormEncrypt::addOpen($options);
        });
        Event::listen('form.input', function($options)
        {
            FormEncrypt::addInput($options);
        });
        Event::listen('form.close', function()
        {
            return FormEncrypt::getToken();
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
