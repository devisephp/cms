<?php namespace Devise\Support\Console;

use Illuminate\Container\Container;

class DeviseUpgradeCommand extends Command
{
    /**
     * Name of the command.
     *
     * @param string
     */
    protected $name = 'devise:upgrade';

    /**
     * Necessary to let people know, in case the name wasn't clear enough.
     *
     * @param string
     */
    protected $description = 'Handles upgrading devise applications';

    /**
     * Setup the application container as we'll need this for running migrations.
     */
    public function __construct(Container $app)
    {
        parent::__construct();
        $this->app = $app;
        $this->DevisePublishAssetsCommand = new DevisePublishAssetsCommand($this->app);
        $this->DeviseMigrateCommand = new DeviseMigrateCommand($this->app);
        $this->DeviseSeedCommand = new DeviseSeedCommand($this->app);
    }

    /**
     * Run the package migrations.
     */
    public function handle()
    {
        $this->DevisePublishAssetsCommand->handle();
        $this->DeviseMigrateCommand->handle();
        $this->DeviseSeedCommand->handle();
    }
}