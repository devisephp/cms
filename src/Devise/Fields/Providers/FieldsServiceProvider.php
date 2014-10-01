<?php namespace Devise\Fields\Providers;

use Event;
use Illuminate\Support\ServiceProvider;

class FieldsServiceProvider extends ServiceProvider
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
        Event::listen('devise.video.field.updated', 'Devise\Fields\Events\VideoFieldUpdated');
        Event::listen('devise.image.field.updated', 'Devise\Fields\Events\ImageFieldUpdated');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

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
