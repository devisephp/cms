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

    	$this->Framework = new \Devise\Support\Framework;

        $this->DeviseInstallCommand = new DeviseInstallCommand($this->Framework->Container);
        $this->DeviseInstallCommand->Cache = m::mock('CacheObj');
        $this->DeviseInstallCommand->Artisan = m::mocK('ArtisanObj');
		$this->DeviseInstallCommand->DeviseMigrateCommand = m::mock('Devise\Support\Console\DeviseMigrateCommand');
		$this->DeviseInstallCommand->DeviseSeedCommand = m::mock('Devise\Support\Console\DeviseSeedCommand');
		$this->DeviseInstallCommand->DevisePublishAssetsCommand = m::mock('Devise\Support\Console\DevisePublishAssetsCommand');
		$this->DeviseInstallCommand->DevisePublishConfigsCommand = m::mock('Devise\Support\Console\DevisePublishConfigsCommand');

		$this->DeviseInstallCommand->io = m::mock('Devise\Support\Console\DeviseInstallCommand');
    	$this->DeviseInstallCommand->io->shouldReceive('ask')->andReturn('');
    	$this->DeviseInstallCommand->io->shouldReceive('comment')->andReturn('');
    	$this->DeviseInstallCommand->io->shouldReceive('error')->andReturn('');

    	$this->DeviseInstallCommand->wizard = m::mock('Devise\Support\Installer\InstallWizard');

    	$this->DeviseInstallCommand->basePath = 'vfs://basedir';
        $this->DeviseInstallCommand->envMock = true;
    }

    public function test_it_handles_install_command()
    {
    	$this->DeviseInstallCommand->wizard->shouldReceive('refreshEnvironment')->twice();
    	$this->DeviseInstallCommand->wizard->shouldReceive('saveEnvironment')->with('local')->once();
        $this->DeviseInstallCommand->wizard->shouldReceive('saveConfigsOverride')->once()->andReturn();
    	$this->DeviseInstallCommand->wizard->shouldReceive('saveDatabase')->with('mysql', 'localhost', 'devisephp', 'root', '', 'yes', 'yes')->once()->andReturn();
        $this->DeviseInstallCommand->Artisan->shouldReceive('call')->twice();
		$this->DeviseInstallCommand->wizard->shouldReceive('createAdminUser')->once();
		$this->DeviseInstallCommand->DeviseMigrateCommand->shouldReceive('handle')->once();
		$this->DeviseInstallCommand->DeviseSeedCommand->shouldReceive('handle')->once();
		$this->DeviseInstallCommand->DevisePublishAssetsCommand->shouldReceive('handle')->once();
		$this->DeviseInstallCommand->DevisePublishConfigsCommand->shouldReceive('handle');
    	$this->DeviseInstallCommand->handle();
    }

	public function test_it_runs_install_commands()
	{
		$this->DeviseInstallCommand->DeviseMigrateCommand->shouldReceive('handle')->once();
		$this->DeviseInstallCommand->DeviseSeedCommand->shouldReceive('handle')->once();
		$this->DeviseInstallCommand->DevisePublishAssetsCommand->shouldReceive('handle')->once();
        $this->DeviseInstallCommand->Artisan->shouldReceive('call')->twice();
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