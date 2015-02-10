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
		$this->registerDeviseLaravelConsoleCommands();
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

    /**
     * Register the installer command for devise
     *
     * @return void
     */
    private function registerDeviseLaravelConsoleCommands()
    {
        $this->app->singleton('command.devise.install', function($app)
        {
            return new Console\DeviseInstallCommand($this->app);
        });

        $this->app->singleton('command.devise.assets', function($app)
        {
            return new Console\DevisePublishAssetsCommand($this->app);
        });

        $this->app->singleton('command.devise.migrate', function($app)
        {
            return new Console\DeviseMigrateCommand($this->app);
        });

        $this->app->singleton('command.devise.seed', function($app)
        {
            return new Console\DeviseSeedCommand($this->app);
        });

        $this->commands(['command.devise.install', 'command.devise.assets', 'command.devise.seed', 'command.devise.migrate']);
    }

}
