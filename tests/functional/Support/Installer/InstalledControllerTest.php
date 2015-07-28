<?php namespace Devise\Support\Installer;

use Mockery as m;

class InstalledControllerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->Framework = m::mock('\Devise\Support\Framework');
        $this->Framework->Redirect = m::mock('\Illuminate\Routing\Redirector');

        $this->InstalledController = new \Devise\Support\Installer\InstalledController($this->Framework);
    }

    public function test_it_gets_index()
    {
        $this->Framework->Redirect->shouldReceive('to')->once()->andReturnSelf();
        $this->InstalledController->getIndex();
    }

    public function test_it_gets_welcome()
    {
        $this->Framework->Redirect->shouldReceive('to')->once()->andReturnSelf();
        $this->InstalledController->getWelcome();
    }

    public function test_welcome_gets_assets()
    {
        $this->Framework->Redirect->shouldReceive('to')->once()->andReturnSelf();
        $this->InstalledController->getInformInstallAssets();
    }

    public function test_gets_assets()
    {
        $this->Framework->Redirect->shouldReceive('to')->once()->andReturnSelf();
        $this->InstalledController->getAssets();
    }

    public function test_it_can_get_environment()
    {
        $this->Framework->Redirect->shouldReceive('to')->once()->andReturnSelf();
        $this->InstalledController->getEnvironment();
    }

    public function test_it_can_post_environment()
    {
        $this->Framework->Redirect->shouldReceive('to')->once()->andReturnSelf();
        $this->InstalledController->postEnvironment();
    }

    public function test_it_gets_database()
    {
        $this->Framework->Redirect->shouldReceive('to')->once()->andReturnSelf();
        $this->InstalledController->getDatabase();
    }

    public function test_it_posts_database()
    {
        $this->Framework->Redirect->shouldReceive('to')->once()->andReturnSelf();
        $this->InstalledController->postDatabase();
    }

    public function test_it_gets_application()
    {
        $this->Framework->Redirect->shouldReceive('to')->once()->andReturnSelf();
        $this->InstalledController->getApplication();
    }

    public function test_it_posts_application()
    {
        $this->Framework->Redirect->shouldReceive('to')->once()->andReturnSelf();
        $this->InstalledController->postApplication();
    }

    public function test_it_gets_create_user()
    {
        $this->Framework->Redirect->shouldReceive('to')->once()->andReturnSelf();
        $this->InstalledController->getCreateUser();
    }

    public function test_it_posts_create_user()
    {
        $this->Framework->Redirect->shouldReceive('to')->once()->andReturnSelf();
        $this->InstalledController->postCreateUser();
    }
}