<?php namespace Devise\Support\Console;

use Mockery as m;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

class DeviseInstallCommandTest extends \DeviseTestCase
{
    public function setUp()
    {
    	parent::setUp();

        $structure = array(
            'config' => array(
            	'auth.php' => $this->fixture('auth-config'),
            	'database.php' => $this->fixture('database-config'),
            )
        );

        vfsStream::setup('basedir', null, $structure);

        $Framework = new \Devise\Support\Framework;

        $app = m::mock('Illuminate\Container\Container');
        $app->shouldReceive('basePath')->andReturn(base_path());
        $app->shouldReceive('make')->with('config')->andReturn($Framework->Container->make('config'));

        $this->DeviseInstallCommand = new DeviseInstallCommand($app);
        $this->DeviseInstallCommand->Cache = m::mock('CacheObj');
        $this->DeviseInstallCommand->Artisan = m::mocK('ArtisanObj');
		$this->DeviseInstallCommand->DeviseMigrateCommand = m::mock('Devise\Support\Console\DeviseMigrateCommand');
		$this->DeviseInstallCommand->DeviseSeedCommand = m::mock('Devise\Support\Console\DeviseSeedCommand');
		$this->DeviseInstallCommand->DevisePublishAssetsCommand = m::mock('Devise\Support\Console\DevisePublishAssetsCommand');
		$this->DeviseInstallCommand->DevisePublishConfigsCommand = m::mock('Devise\Support\Console\DevisePublishConfigsCommand');

        $this->DeviseInstallCommand->io = new MockedResponseIOHandlerForDeviseInstallCommand;
    	$this->DeviseInstallCommand->wizard = m::mock('Devise\Support\Installer\InstallWizard');

    	$this->DeviseInstallCommand->basePath = 'vfs://basedir';
        $this->DeviseInstallCommand->envMock = true;
    }

    public function test_it_handles_install_command()
    {
        \Artisan::shouldReceive('call')->with('db:seed');
        
        $migrator = m::mock('Migrator');
        $migrator->shouldReceive('run');
        $migrationRepository = m::mock('MigrationRepository');
        $migrationRepository->shouldReceive('repositoryExists')->andReturn(true);
        $seeder = m::mock('Seeder');
        $seeder->shouldReceive('call');
        $this->DeviseInstallCommand->app->shouldReceive('make')->with('migration.repository')->andReturn($migrationRepository);
        $this->DeviseInstallCommand->app->shouldReceive('make')->with('migrator')->andReturn($migrator);
        $this->DeviseInstallCommand->app->shouldReceive('make')->with('seeder')->andReturn($seeder);
    	$this->DeviseInstallCommand->wizard->shouldReceive('refreshEnvironment')->twice();
    	$this->DeviseInstallCommand->wizard->shouldReceive('saveEnvironment')->with('local')->once();
        $this->DeviseInstallCommand->wizard->shouldReceive('saveConfigsOverride')->once()->andReturn();
        $this->DeviseInstallCommand->wizard->shouldReceive('saveDatabase')->with('mysql', 'localhost', 'devisephp', 'root', '')->once()->andReturn();
    	$this->DeviseInstallCommand->wizard->shouldReceive('saveApplicationMigrationAndSeedSettings')->with('yes','yes')->once()->andReturn();
        $this->DeviseInstallCommand->wizard->shouldReceive('createAdminUser')->once();
		$this->DeviseInstallCommand->wizard->shouldReceive('saveApplicationNamespace')->once();
		$this->DeviseInstallCommand->DeviseMigrateCommand->shouldReceive('handle')->once();
		$this->DeviseInstallCommand->DeviseSeedCommand->shouldReceive('handle')->once();
		$this->DeviseInstallCommand->DevisePublishAssetsCommand->shouldReceive('handle')->once();
		$this->DeviseInstallCommand->DevisePublishConfigsCommand->shouldReceive('handle');
    	$this->DeviseInstallCommand->handle();
    }

	public function test_it_runs_install_commands()
	{
        \Artisan::shouldReceive('call')->with('db:seed');

        $migrator = m::mock('Migrator');
        $migrator->shouldReceive('run');
        $migrationRepository = m::mock('MigrationRepository');
        $migrationRepository->shouldReceive('repositoryExists')->andReturn(true);
        $seeder = m::mock('Seeder');
        $seeder->shouldReceive('call');
        $this->DeviseInstallCommand->app->shouldReceive('make')->with('migration.repository')->andReturn($migrationRepository);
        $this->DeviseInstallCommand->app->shouldReceive('make')->with('migrator')->andReturn($migrator);
        $this->DeviseInstallCommand->app->shouldReceive('make')->with('seeder')->andReturn($seeder);
		$this->DeviseInstallCommand->DeviseMigrateCommand->shouldReceive('handle')->once();
		$this->DeviseInstallCommand->DeviseSeedCommand->shouldReceive('handle')->once();
		$this->DeviseInstallCommand->DevisePublishAssetsCommand->shouldReceive('handle')->once();
		$this->DeviseInstallCommand->DevisePublishConfigsCommand->shouldReceive('handle');
		$this->DeviseInstallCommand->runInstallCommands();
	}

	public function test_it_changes_database_config_file()
	{
        $this->DeviseInstallCommand->Config = m::mock('ConfigObj');
        $this->DeviseInstallCommand->Config->shouldReceive('get')->once()->andReturn('mysql');
		$this->DeviseInstallCommand->changeDatabaseConfigFile();
		$contents = file_get_contents('vfs://basedir/config/database.php');
		assertContains("'default' => env('DB_DEFAULT', 'mysql'),", $contents);
	}

	public function test_it_changes_email_config_file()
	{
		$this->DeviseInstallCommand->changeEmailConfigFile();
		$contents = file_get_contents('vfs://basedir/config/auth.php');
		assertContains("'email' => 'devise::emails.recover-password',", $contents);
	}
}

class MockedResponseIOHandlerForDeviseInstallCommand
{
    public function ask($question, $default = '')
    {
        return $default;
    }

    public function error($message)
    {
        return $message;
    }

    public function comment($message)
    {
        return $message;
    }

    public function askAboutDatabaseType($type)
    {
        return $type;
    }

    public function askAboutDatabaseHost($host)
    {
        return $host;
    }

    public function askAboutDatabaseName($name)
    {
        return $name;
    }

    public function askAboutDatabaseUser($user)
    {
        return $user;
    }

    public function askAboutDatabasePass($pass)
    {
        return $pass;
    }

    public function askAboutDatabaseMigrations($migrations)
    {
        return $migrations;
    }

    public function askAboutDatabaseSeeds($seeds)
    {
        return $seeds;
    }
}