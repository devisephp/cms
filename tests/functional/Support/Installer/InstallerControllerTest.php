<?php namespace Devise\Support\Installer;

use Mockery as m;

class InstallerControllerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->Framework = m::mock('\Devise\Support\Framework');
        $this->InstallWizard = m::mock('\Devise\Support\Installer\InstallWizard');
        $this->Framework->Auth = m::mock('\Illuminate\Auth\Guard');
        $this->Framework->Input = m::mock('\Illuminate\Http\Request');
        $this->Framework->Redirect = m::mock('\Illuminate\Routing\Redirector');
        $this->Framework->View = m::mock('\Illuminate\View\Factory');

        $this->InstallerController = new \Devise\Support\Installer\InstallerController($this->Framework, $this->InstallWizard);
    }

    public function test_it_gets_index()
    {
        $this->Framework->Redirect->shouldReceive('to')->once()->andReturnSelf();
        $this->InstallerController->getIndex();
    }

    public function test_it_gets_welcome()
    {
        $this->InstallWizard->shouldReceive('checkAssets')->once()->andReturn(true);
        $this->Framework->View->shouldReceive('make')->once()->andReturnSelf();
        $this->InstallerController->getWelcome();
    }

    public function test_welcome_gets_assets()
    {
        $this->InstallWizard->shouldReceive('checkAssets')->once()->andReturn(false);
        $this->Framework->Redirect->shouldReceive('to')->once()->andReturnSelf();
        $this->InstallerController->getWelcome();
    }

    public function test_it_can_get_environment()
    {
        $this->Framework->Input->shouldReceive('old')->once()->andReturn('production');
        $this->Framework->View->shouldReceive('make')->once()->andReturnSelf();

        $this->InstallerController->getEnvironment();
    }

    public function test_it_can_post_environment()
    {
        $this->Framework->Input->shouldReceive('get')->twice()->andReturn('production');
        $this->InstallWizard
        	->shouldReceive('saveNewApplicationKey')
        	->once()
        	->andReturnSelf()
        	->shouldReceive('saveEnvironment')
        	->once()
        	->andReturnNull();

        $this->Framework->Redirect->shouldReceive('to')->once()->andReturnSelf();

        $this->InstallerController->postEnvironment();
    }

    public function test_it_gets_database()
    {
        $this->Framework->Input->shouldReceive('old')->times(5)->andReturn('production');
        $this->Framework->View->shouldReceive('make')->once()->andReturnSelf();

        $this->InstallerController->getDatabase();
    }

    public function test_it_posts_database()
    {
    	$this->Framework->Input->shouldReceive('get')->times(5)->andReturn('production');
        $this->InstallWizard->shouldReceive('saveDatabase')->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('to')->once()->andReturnSelf();

        $this->InstallerController->postDatabase();
    }

    public function test_it_gets_application()
    {
        $this->markTestIncomplete();
    }

    public function test_it_posts_application()
    {
        $this->markTestIncomplete();
    }

    public function test_it_gets_create_user()
    {
        $this->Framework->Input->shouldReceive('old')->andReturn('foo@email.com');
        $this->Framework->View->shouldReceive('make')->once()->andReturnSelf();

        $this->InstallerController->getCreateUser();
    }

    public function test_it_posts_create_user()
    {
        $this->Framework->Input->shouldReceive('get')->times(3)->andReturn('foo@email.com', 'foouser', 'fooPass');
        $this->InstallWizard
            ->shouldReceive('validateAdminUser', 'installDevise')
            ->once()
            ->andReturnNull()
            ->shouldReceive('createAdminUser')
            ->once()
            ->andReturn(new \DvsUser);

        $this->Framework->Auth->shouldReceive('loginUsingId')->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('to')->once()->andReturnSelf();

        $this->InstallerController->postCreateUser();
    }
}