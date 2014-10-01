<?php namespace Devise\User\Providers;

use RuleManager;
use Illuminate\Support\ServiceProvider;
use View;

class UserServiceProvider extends ServiceProvider {

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
        include __DIR__ . '/../routes.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // bind singleton of 'rulelist'
        $this->app->singleton('rulelist', 'Devise\User\Permissions\RuleList');

        //bind 'deviseuser' to UserHelper Class (for facade)
        $this->app->bind('deviseuser', 'Devise\User\Helpers\UserHelper');

        //bind 'rulemanager' to RuleManager Class (for facade)
        $this->app->bind('rulemanager', 'Devise\User\Permissions\RuleManager');
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