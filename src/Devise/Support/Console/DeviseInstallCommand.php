<?php namespace Devise\Support\Console;

use Illuminate\Console\Command;
use Illuminate\Container\Container;

class DeviseInstallCommand extends Command
{
    /**
     * Name of the command.
     *
     * @param string
     */
    protected $name = 'devise:install';

    /**
     * Necessary to let people know, in case the name wasn't clear enough.
     *
     * @param string
     */
    protected $description = 'Handles installing devise tables, seeds, etc';

    /**
     * Setup the application container as we'll need this for running migrations.
     */
    public function __construct(Container $app)
    {
        parent::__construct();

        $this->app = $app;
    }

    /**
     * Run the package migrations.
     */
    public function handle()
    {
        $command = new DeviseMigrateCommand($this->app);
        $command->handle();

        $command = new DeviseSeedCommand($this->app);
        $command->handle();

        $command = new DevisePublishAssetsCommand($this->app);
        $command->handle();

        $command = new DevisePublishConfigsCommand($this->app);
        $command->handle();
    }
}