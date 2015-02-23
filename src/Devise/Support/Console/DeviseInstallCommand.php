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

        $this->basePath = $this->app->basePath();
    }

    /**
     * Run the package migrations.
     */
    public function handle()
    {
        $this->changeDatabaseConfigFile();

        $this->changeEmailConfigFile();

        $command = new DeviseMigrateCommand($this->app);
        $command->handle();

        $command = new DeviseSeedCommand($this->app);
        $command->handle();

        $command = new DevisePublishAssetsCommand($this->app);
        $command->handle();

        $command = new DevisePublishConfigsCommand($this->app);
        $command->handle();
    }

    /**
     * Changes the default out of the box Laravel database
     * config to include other env() settings that we will
     * use in Devise such as 'default' and we also update
     * the sqlite driver stuff
     *
     * @return void
     */
    public function changeDatabaseConfigFile()
    {
        $databaseConfigFile = $this->basePath . '/config/database.php';

        $contents = file_get_contents($databaseConfigFile);

        $driver = \Config::get('database.default');

        $modified = str_replace("'default' => '{$driver}',", "'default' => env('DB_DEFAULT', 'mysql'),", $contents);

        if ($contents !== $modified) file_put_contents($databaseConfigFile, $modified);
    }

    /**
     * Changes the email config file out of the box to include
     * devise as the password reminder view instead of the other
     * view
     *
     * @return void
     */
    public function changeEmailConfigFile()
    {
        $databaseConfigFile = $this->basePath . '/config/auth.php';

        $contents = file_get_contents($databaseConfigFile);

        $modified = str_replace("'email' => 'emails.password',", "'email' => 'devise::emails.recover-password',", $contents);

        if ($contents !== $modified) file_put_contents($databaseConfigFile, $modified);
    }
}