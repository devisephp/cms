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

    protected $excludeTables = array();

    /**
     * Setup the application container as we'll need this for running migrations.
     */
    public function __construct(Container $app)
    {
        parent::__construct();

        $this->app = $app;
        $this->Schema = \Schema::getFacadeRoot();
    }

    /**
     * Run the package migrations.
     */
    public function handle()
    {
        $migrations = $this->app->make('migration.repository');

        if (! $migrations->repositoryExists()) $migrations->createRepository();

        $refreshDB = $this->askAboutRefreshingDatabase();

        if($refreshDB == 'yes') {
            if ($this->askAboutExcludingUsersTable() == 'yes') {
                $this->excludeTables[] = 'users';
                $this->excludeTables[] = 'group_user';
            }

            $this->dropDatabaseTables();

            $this->call('devise:migrate');
            $this->call('migrate');

            $this->call('devise:seed');
            $this->call('db:seed');
        }
    }

    /**
     * Prompt for wiping and re-populating the current database
     *
     * @param  boolean $default
     * @return boolean
     */
    private function askAboutRefreshingDatabase($default = 'yes')
    {
        $answer = $this->ask('This will refresh the entire database. Are you sure? ['.$default.']');
        return $answer ?: $default;
    }

    /**
     * Prompt for asking which tables to include in excludeTables array
     *
     * @todo   add abilty to add "--table" option to accept comma seperated list of tablenames
     * @param  boolean $default
     * @return boolean
     */
    private function askAboutExcludingUsersTable($default = 'yes')
    {
        $answer = $this->ask('Would you like to keep the "users" table? ['.$default.']');
        return $answer ?: $default;
    }

    /**
     * Truncates all tables in current database except
     * for any listed in the class property excludeTables.
     *
     * @return Void
     */
    private function dropDatabaseTables()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');

        // gets all tables names in current database
        $tables = $this->Schema->getConnection()
            ->getDoctrineSchemaManager()
            ->listTableNames();

        // loop tables and drop any not in $excludeTables array
        foreach($tables as $table) {
            if (in_array($table, $this->excludeTables)) {
                continue;
            }

            $this->Schema->drop($table);
        }
    }
}