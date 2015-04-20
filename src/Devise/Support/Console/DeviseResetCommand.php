<?php namespace Devise\Support\Console;

use Illuminate\Console\Command;
use Illuminate\Container\Container;

class DeviseResetCommand extends Command
{
    /**
     * Name of the command.
     *
     * @param string
     */
    protected $name = 'devise:reset';

    /**
     * Description of reset-project command
     *
     * @param string
     */
    protected $description = 'Resets a project by dropping db tables and running migrations and seeds for Devise and then the application. All configs and files are left untouched';

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
        $migrations = $this->app->make('migration.repository');

        if (! $migrations->repositoryExists()) $migrations->createRepository();

        // remove all existing tables from DB
        $this->dropDatabaseTables();

        \Artisan::call('devise:migrate');
        \Artisan::call('migrate');

        \Artisan::call('devise:seed');
        \Artisan::call('db:seed');
    }

    /**
     * Truncates all tables in current database except
     * for any listed in the $excludeArr.
     *
     * @return Void
     */
    private function dropDatabaseTables()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // gets all tables names in current database
        $tables = \Schema::getConnection()
            ->getDoctrineSchemaManager()
            ->listTableNames();

        // any tables to exclude from dropping
        $excludeArr = ['group_user', 'users'];

        // loop thru tables and drop any not in excludeArr
        foreach($tables as $table) {
            if (in_array($table, $excludeArr)) { continue; }

            \Schema::drop($table);
        }
    }
}