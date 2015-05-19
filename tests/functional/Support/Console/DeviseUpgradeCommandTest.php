<?php namespace Devise\Support\Console;

use Mockery as m;

class DeviseUpgradeCommandTest extends \DeviseTestCase
{
    public function setUp()
    {
    	parent::setUp();

        $app = m::mock("Illuminate\Container\Container");
        $this->DeviseUpgradeCommand = new DeviseUpgradeCommand($app);
		$this->DeviseUpgradeCommand->DeviseMigrateCommand = m::mock('Devise\Support\Console\DeviseMigrateCommand');
		$this->DeviseUpgradeCommand->DeviseSeedCommand = m::mock('Devise\Support\Console\DeviseSeedCommand');
		$this->DeviseUpgradeCommand->DevisePublishAssetsCommand = m::mock('Devise\Support\Console\DevisePublishAssetsCommand');
    }

    public function test_it_handles_upgrade_command()
    {
		$this->DeviseUpgradeCommand->DeviseMigrateCommand->shouldReceive('handle')->once();
		$this->DeviseUpgradeCommand->DeviseSeedCommand->shouldReceive('handle')->once();
		$this->DeviseUpgradeCommand->DevisePublishAssetsCommand->shouldReceive('handle')->once();
    	$this->DeviseUpgradeCommand->handle();
    }
}