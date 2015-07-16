<?php namespace Devise\Support\Console;

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
     * The Devise install wizard
     *
     * @var Devise\Support\Installer\InstallWizard
     */
    public $wizard;
    /**
     * This input output object for
     * writing to console
     *
     * @var Devise\Support\Console\DeviseInstallCommand
     */
    public $io;
    /**
     * Mocks the environment
     *
     * @var Mockery
     */
    public $envMock;
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
        $this->Config = $this->app->make('config');
        $this->DeviseMigrateCommand = new DeviseMigrateCommand($this->app);
        $this->DeviseSeedCommand = new DeviseSeedCommand($this->app);
        $this->DevisePublishAssetsCommand = new DevisePublishAssetsCommand($this->app);
        $this->DevisePublishConfigsCommand = new DevisePublishConfigsCommand($this->app);
        $this->Artisan = \Artisan::getFacadeRoot();
    }

    /**
     * Run the package migrations.
     */
    public function handle()
    {
        $this->wizard()->refreshEnvironment();
        $this->setupEnvironment();
        $this->setupDatabase();
        $this->setupConfigOverrides();
        $this->setupAppName();
        $this->wizard()->refreshEnvironment();

        list($email, $user, $pass) = $this->setupAdminUser();
        $this->io()->comment("Please wait while devise is installing...");

        $this->runInstallCommands();
        $this->wizard()->createAdminUser($email, $user, $pass);
    }

    /**
     * Runs the install commands for migrations, seeds,
     * publishing assets and configs
     *
     * @return void
     */
    public function runInstallCommands()
    {
        $this->changeDatabaseConfigFile();
        $this->changeEmailConfigFile();
        $this->DevisePublishAssetsCommand->handle();

        if ($this->env('APP_MIGRATIONS') != 'no') {
            $this->runApplicationMigrations();
        }

        $this->DeviseMigrateCommand->handle();

        $this->DeviseSeedCommand->handle();

        if ($this->env('APP_SEEDS') != 'no') {
            $this->runApplicationSeeds();
        }

        if ($this->env('CONFIGS_OVERRIDE') == 'yes') {
            $this->DevisePublishConfigsCommand->handle();
        }

        if ($this->env('APP_NAME')) {
            $this->Artisan->call('app:name', [ 'name' => $this->env('APP_NAME') ]);
        }
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
        $driver = $this->Config->get('database.default');
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
        $authConfigFile = $this->basePath . '/config/auth.php';
        $contents = file_get_contents($authConfigFile);
        $modified = str_replace("'email' => 'emails.password',", "'email' => 'devise::emails.recover-password',", $contents);
        if ($contents !== $modified) file_put_contents($authConfigFile, $modified);
    }

    /**
     * Runs the application seeds
     *
     * @return void
     */
    protected function runApplicationSeeds()
    {
        $seeder = $this->app->make('seeder');
        $seeder->call('DatabaseSeeder');
    }

    /**
     * Runs the application migrations
     * @return void
     */
    protected function runApplicationMigrations()
    {
        $migrations = $this->app->make('migration.repository');

        if (! $migrations->repositoryExists()) $migrations->createRepository();

        $migrator = $this->app->make('migrator');

        $migrator->run(base_path() . '/database/migrations');
    }

    /**
     * [askAboutEnvironment description]
     * @return [type]
     */
    protected function setupEnvironment()
    {
        $default = $this->env('APP_ENV', 'local');
        $answer = $this->io()->ask("What environment is this?", $default);
        $this->wizard()->saveEnvironment($answer);
        return $answer;
    }

    /**
     * [setupAppName description]
     * @return [type]
     */
    protected function setupAppName()
    {
        $default = $this->env('APP_NAME', 'App');
        $answer = $this->io()->ask("What is your Application name?", $default);
        $this->wizard->saveApplicationNamespace($default);
        return $answer;
    }

    /**
     * [setupDatabase description]
     * @return [type]
     */
    protected function setupDatabase()
    {
        $databaseNotInstalled = true;
        $type = $this->env('DB_DEFAULT', 'mysql');
        $host = $this->env('DB_HOST', 'localhost');
        $name = $this->env('DB_DATABASE', 'devisephp');
        $user = $this->env('DB_USERNAME', 'root');
        $pass = $this->env('DB_PASSWORD', '');
        $migrations = $this->env('APP_MIGRATIONS', 'yes');
        $seeds = $this->env('APP_SEEDS', 'yes');

        while ($databaseNotInstalled)
        {
            $type = $this->io()->askAboutDatabaseType($type);
            $host = $this->io()->askAboutDatabaseHost($host);
            $name = $this->io()->askAboutDatabaseName($name);
            $user = $this->io()->askAboutDatabaseUser($user);
            $pass = $this->io()->askAboutDatabasePass($pass);
            $migrations = $this->io()->askAboutDatabaseMigrations($migrations);
            $seeds = $this->io()->askAboutDatabaseSeeds($seeds);

            $this->wizard()->saveDatabase($type, $host, $name, $user, $pass);
            $this->wizard()->saveApplicationMigrationAndSeedSettings($migrations, $seeds);

            if ($this->wizard()->errors)
            {
                $this->spitOutErrors($this->wizard->errors->all());
            }
            else
            {
                $databaseNotInstalled = false;
            }
        }

    }

    /**
     * [setupConfigOverrides description]
     * @return [type]
     */
    protected function setupConfigOverrides()
    {
        $default = $this->env('CONFIGS_OVERRIDE', 'yes');
        $answer = $this->io()->ask("Do you want override all Devise configs?", $default);
        $this->wizard()->saveConfigsOverride($answer);
    }

    /**
     * [setupAdminUser description]
     * @return [type]
     */
    protected function setupAdminUser()
    {
        $email = "no-reply@devisephp.com";
        $user = "devise";
        $pass = "password";
        $email = $this->io()->ask("Admin email", $email);
        $user = $this->io()->ask("Admin username", $user);
        $pass = $this->io()->ask("Admin password", $pass);
        return array($email, $user, $pass);
    }

    /**
     * [askAboutDatabase description]
     * @return [type]
     */
    protected function askAboutDatabaseType($default)
    {
        $types = ['mysql', 'pgsql', 'sqlite', 'sqlsrv'];
        $typeslist = implode(', ', $types);
        $answer = $this->io()->ask("What database type are you using? {$typeslist}", $default);
        if (!in_array($answer, $types))
        {
                $this->io()->error("Invalid database type: {$answer}");
                return $this->io()->askAboutDatabaseType($default);
        }
        return $answer ?: $default;
    }

    /**
     * [askAboutDatabaseHost description]
     * @param  [type] $default
     * @return [type]
     */
    protected function askAboutDatabaseHost($default)
    {
        return $this->io()->ask("What is your database host?", $default);
    }

    /**
     * [askAboutDatabaseName description]
     * @param  [type] $default
     * @return [type]
     */
    protected function askAboutDatabaseName($default)
    {
        return $this->io()->ask("What is your database name?", $default);
    }

    /**
     * [askAboutDatabaseUser description]
     * @param  [type] $default
     * @return [type]
     */
    protected function askAboutDatabaseUser($default)
    {
        return $this->io()->ask("What is your database username?", $default);
    }

    /**
     * [askAboutDatabasePass description]
     * @param  [type] $default
     * @return [type]
     */
    protected function askAboutDatabasePass($default)
    {
        // allows for empty passwords
        if ($default === '') $default = ' ';

        $answer = $this->io()->ask("What is your database password?", $default);

        return trim($answer) === '' ? '' : $answer;;
    }

    /**
     * Prompt for executing database migrations
     *
     * @param  boolean $default
     * @return boolean
     */
    protected function askAboutDatabaseMigrations($default)
    {
        return $this->io()->ask("Do you want to run the application's db migrations?", $default);
    }

    /**
     * Prompt for executing database seeds
     *
     * @param  boolean $default
     * @return boolean
     */
    protected function askAboutDatabaseSeeds($default)
    {
        return $this->io()->ask("Do you want to run the application's db seeds?", $default);
    }

    /**
     * [spitOutErrors description]
     * @param  [type] $messages
     * @return [type]
     */
    protected function spitOutErrors($messages)
    {
        foreach ($messages as $message)
        {
            $this->io()->error($message);
        }
    }

    /**
     * The wizard for the installer
     *
     * @return InstallWizard
     */
    protected function wizard()
    {
        if (!$this->wizard)
        {
            $this->wizard = $this->app->make('Devise\Support\Installer\InstallWizard');
        }
        return $this->wizard;
    }

    /**
     * The input output handler (used this way for mocking)
     *
     * @return DeviseInstallCommand
     */
    protected function io()
    {
        return $this->io ?: $this;
    }

    /**
     * [env description]
     * @param  [type] $setting
     * @param  [type] $default
     * @return [type]
     */
    protected function env($setting, $default = null)
    {
        if ($this->envMock) return $default;
        return env($setting, $default);
    }
}