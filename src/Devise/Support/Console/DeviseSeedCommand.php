<?php namespace Devise\Support\Console;

use Illuminate\Container\Container;

class DeviseSeedCommand extends Command
{
    /**
     * Name of the command.
     *
     * @param string
     */
    protected $name = 'devise:seed';

    /**
     * Necessary to let people know, in case the name wasn't clear enough.
     *
     * @param string
     */
    protected $description = 'Handles installing devise seeds';

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
        $seeder = $this->app->make('seeder');
        $seeder->call('DeviseSeeder');
    }
}