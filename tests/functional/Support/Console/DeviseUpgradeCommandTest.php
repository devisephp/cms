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
        $this->DeviseUpgradeCommand->io = m::mock('InputOutput');
        $this->DeviseUpgradeCommand->base_path = '/base';
        $this->DeviseUpgradeCommand->public_path = '/base/public';
        $this->DeviseUpgradeCommand->__DIR__ = '__DIR__/path';
        $this->DeviseUpgradeCommand->FileDiff = m::mock('Devise\Support\IO\FileDiff');
        $this->DeviseUpgradeCommand->File = m::mock('FileSystem');
    }

    public function test_it_handles_upgrade_command()
    {
        $this->DeviseUpgradeCommand->io->shouldReceive('ask')->andReturn('Y');
        $this->DeviseUpgradeCommand->FileDiff->shouldReceive('different')->andReturn(['a_different_file.txt', 'bar.txt']);
        $this->DeviseUpgradeCommand->FileDiff->shouldReceive('unmodified')->andReturn(['durka.txt']);
        $this->DeviseUpgradeCommand->File->shouldReceive('isDirectory')->andReturn(true);
        $this->DeviseUpgradeCommand->File->shouldReceive('copy')->andReturn(true);
		$this->DeviseUpgradeCommand->DeviseMigrateCommand->shouldReceive('handle')->once();
		$this->DeviseUpgradeCommand->DeviseSeedCommand->shouldReceive('handle')->once();
    	$this->DeviseUpgradeCommand->handle();
    }
}