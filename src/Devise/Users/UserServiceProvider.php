<?php namespace Devise\Users;

/**
 * Class UserServiceProvider registers the devise user, rulelist and rulemanager
 * facades
 *
 * @package Devise\Users
 */
class UserServiceProvider extends \Illuminate\Support\ServiceProvider
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
        //bind 'deviseuser' to UserHelper Class (for facade)
        $this->app->bind('deviseuser', 'Devise\Users\UserHelper');

        // bind singleton of 'rulelist'
        $this->app->singleton('rulelist', 'Devise\Users\Permissions\RuleList');

        //bind 'rulemanager' to RuleManager Class (for facade)
        $this->app->bind('rulemanager', 'Devise\Users\Permissions\RuleManager');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('deviseuser', 'rulelist', 'rulemanager');
    }
}