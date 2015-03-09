<?php namespace Devise\Support\Installer;

use Mockery as m;

class InstallWizardTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->previousEnv = app()['env'];
        $this->SettingsManager = m::mock('\Devise\Support\Config\SettingsManager');
        $this->EnvironmentFileManager = m::mock('\Devise\Support\Config\EnvironmentFileManager');
        $this->Framework = m::mock('\Devise\Support\Framework');
        $this->Framework->Validator = m::mock('\Illuminate\Validation\Factory');
        $this->Framework->Hash = m::mock('\Illuminate\Hashing\BcryptHasher');
        $this->Framework->Schema = m::mock('\Illuminate\Database\Schema\Builder');
        $this->DatabaseCreator = m::mock('\Devise\Support\Installer\DatabaseCreator');
        $this->DeviseInstallCommand = m::mock('\Devise\Support\Console\DeviseInstallCommand');
        $this->Framework->Config = m::mock('Illuminate\Config\Repository');

        $this->InstallWizard = new InstallWizard(
            $this->SettingsManager,
            $this->EnvironmentFileManager,
            $this->Framework,
            $this->DatabaseCreator,
            $this->DeviseInstallCommand,
            new \DvsUser,
            new \DvsGroup
        );
    }

    public function tearDown()
    {
        parent::tearDown();
        app()['env'] = $this->previousEnv;
    }

	public function test_it_validates_admin_user()
	{
        $this->Framework->Validator
            ->shouldReceive('make')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('fails')
            ->once()
            ->andReturn(false);

		$this->InstallWizard->validateAdminUser('foo@email.com', 'fooPass');

        $this->assertCount(0, $this->InstallWizard->errors);
        $this->assertInternalType('array', $this->InstallWizard->errors);
	}

	public function test_it_creates_admin_user()
	{
        $this->Framework->Hash
            ->shouldReceive('make')
            ->once()
            ->andReturn('&5y$21%lIpwAOghJs2pjLGIoCfsGwiWryIlNQcBejtRrv0/RRjLiyEnVO\9P');

        $output = $this->InstallWizard->createAdminUser('admin@email.com', 'fooAdminPass');

        $this->assertEquals('admin@email.com', $output->email);
        $this->assertInstanceOf('DvsUser', $output);
    }

    public function test_it_saves_environment()
    {
        $this->Framework->Validator
            ->shouldReceive('make')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('fails')
            ->once()
            ->andReturn(false);

        $this->EnvironmentFileManager->shouldReceive('merge')->once()->andReturnSelf();

        $this->assertNull( $this->InstallWizard->saveEnvironment('production') );
	}

	public function test_it_saves_database()
	{
        $this->Framework->Config->shouldReceive('set');

        $this->DeviseInstallCommand
            ->shouldReceive('changeDatabaseConfigFile')
            ->once()
            ->andReturn(false);

        $this->EnvironmentFileManager
            ->shouldReceive('merge', 'createIfNotExists')
            ->once()
            ->andReturnNull();

		$output = $this->InstallWizard->saveDatabase('sqlite', ':memory:', 'testDB', 'root', '');

        $this->assertNull($output);
	}

	public function test_it_installs_devise()
	{
        $this->Framework->Schema->shouldReceive('hasTable')->once()->andReturn(false);

        $this->EnvironmentFileManager
            ->shouldReceive('get')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('merge')
            ->once()
            ->andReturn(['foo' => 'settings']);

        $this->DeviseInstallCommand->shouldReceive('handle')->once()->andReturnNull();

        $this->assertNull( $this->InstallWizard->installDevise() );
	}

	public function test_it_refreshes_environment()
	{
        $this->EnvironmentFileManager->shouldReceive('createIfNotExists')->once()->andReturnNull();
        $this->Framework->Config->shouldReceive('set')->times(17);
        $this->InstallWizard->refreshEnvironment();
	}

}