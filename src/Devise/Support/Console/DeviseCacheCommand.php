<?php namespace Devise\Support\Console;

use Illuminate\Container\Container;
use Config;

class DeviseCacheCommand extends Command
{
    /**
     * Name of the command.
     *
     * @param string
     */
    protected $name = 'devise:cache';

    /**
     * Necessary to let people know, in case the name wasn't clear enough.
     *
     * @param string
     */
    protected $description = 'Handles caching devise routes';

    /**
     * Setup the application container as we'll need this for running migrations.
     */
    public function __construct(Container $app)
    {
        parent::__construct();

        $this->app = $app;

        $this->RoutesGenerator = $this->app->make('Devise\Pages\RoutesGenerator');

        $this->Config = Config::getFacadeRoot();
    }

    /**
     * Run the package migrations.
     */
    public function handle()
    {
        $cached = $this->RoutesGenerator->cacheRoutes();

        if (!$cached)
        {
            $this->info('');
            $this->info('   DEVISE_CACHE_ENABLED=true');
            $this->info('');
            $this->error('should be set in .env before route caching can be enabled on devise');
        }
    }
}