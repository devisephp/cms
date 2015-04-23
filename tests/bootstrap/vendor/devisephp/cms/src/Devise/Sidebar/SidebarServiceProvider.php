<?php namespace Devise\Sidebar;

/**
 * This class loads all the providers in other folders for
 * all of devise. We don't want the developer to have to load
 * 10 different service providers to work with devise, so
 * this class is just a wrapper to load all of the service
 * providers instead of having to load 10 individual ones in
 * the app/config/app.php file
 *
 * This service provider also includes the blade extensions
 */
class SidebarServiceProvider extends \Illuminate\Support\ServiceProvider
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
        \Blade::extend(function($view, $complier)
        {
            return \App::make('Devise\Sidebar\SnippetBladeCompiler')->compile($view);
        });
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
     * @return void
     */
    public function provides()
    {
        return array();
    }
}