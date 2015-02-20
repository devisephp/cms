<?php namespace Devise\Users;

use Mockery as m;

class UsersResponseHandlerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->SessionsRepository = m::mock('Devise\Users\Sessions\SessionsRepository');
        $this->UserManager = m::mock('Devise\Users\UserManager');
        $this->Framework = m::mock('Devise\Support\Framework');
        $this->Framework->Redirect = m::mock('Illuminate\Routing\Redirector');
        $this->UsersResponseHandler = new UsersResponseHandler($this->SessionsRepository, $this->UserManager, $this->Framework);
    }

    public function test_it_can_execute_logout()
    {
        $this->SessionsRepository->shouldReceive('logout')->andReturn(true);
        $this->Framework->Redirect->shouldReceive('route')->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('with')->once()->andReturnSelf();

        $this->UsersResponseHandler->requestLogout();
    }

    public function test_it_cannot_execute_login()
    {
        $this->SessionsRepository->shouldReceive('login')->once()->andReturn(false);
        $this->Framework->Redirect->shouldReceive('route')->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('withInput')->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('withErrors')->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('with')->once()->andReturnSelf();
        $this->UsersResponseHandler->requestLogin(['foo' => 'input data']);
    }

    public function test_it_can_execute_login()
    {
        $this->SessionsRepository->shouldReceive('login')->once()->andReturn(true);
        $this->Framework->Redirect->shouldReceive('route')->once()->andReturnSelf();
        $this->UsersResponseHandler->requestLogin(['foo' => 'input data']);
    }

    public function test_it_can_execute_login_with_an_intended_redirect()
    {
        $this->SessionsRepository->shouldReceive('login')->once()->andReturn(true);
        $this->Framework->Redirect->shouldReceive('to')->with('some/path')->once()->andReturnSelf();
        $this->UsersResponseHandler->requestLogin(['intended' => 'some/path', 'foo' => 'input data']);
    }

    public function test_it_cannot_request_create_user()
    {
        $this->UserManager->errors = true;
        $this->UserManager->message = 'There was an error';
        $this->UserManager->shouldReceive('createUser')->once()->andReturn(false);
        $this->Framework->Redirect->shouldReceive('route')->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('withInput')->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('withErrors')->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('with')->once()->andReturnSelf();

        $this->UsersResponseHandler->requestCreateUser(['foo' => 'input data']);
    }

    public function test_it_can_request_create_user()
    {
        $this->UserManager->shouldReceive('createUser')->once()->andReturn(new \DvsUser);
        $this->Framework->Redirect->shouldReceive('route')->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('with')->once()->andReturnSelf();
        $this->UsersResponseHandler->requestCreateUser(['foo' => 'input data']);
    }

    public function test_it_cannot_request_update_user()
    {
        $this->UserManager->errors = true;
        $this->UserManager->message = 'There was an error';
        $this->UserManager->shouldReceive('updateUser')->once()->andReturn(false);
        $this->Framework->Redirect->shouldReceive('route')->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('withInput')->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('withErrors')->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('with')->once()->andReturnSelf();

        $this->UsersResponseHandler->requestUpdateUser(1, ['foo' => 'input data']);
    }

    public function test_it_can_request_update_user()
    {
        $this->UserManager->shouldReceive('updateUser')->once()->andReturn(new \DvsUser);
        $this->Framework->Redirect->shouldReceive('route')->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('with')->once()->andReturnSelf();
        $this->UsersResponseHandler->requestUpdateUser(1, ['foo' => 'input data']);
    }

    public function test_it_can_request_destroy_user()
    {
        $this->UserManager->shouldReceive('destroyUser')->once()->andReturn(new \DvsUser);
        $this->Framework->Redirect->shouldReceive('route')->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('with')->once()->andReturnSelf();
        $this->UsersResponseHandler->requestDestroyUser(1);
    }

    public function test_it_can_request_register()
    {
        $this->markTestIncomplete();
    }

    public function test_it_cannot_request_register()
    {
        $this->markTestIncomplete();
    }

    public function test_it_can_request_activation()
    {
        $this->markTestIncomplete();
    }

    public function test_it_cannot_request_activation()
    {
        $this->markTestIncomplete();
    }

    public function test_it_can_execute_recover_password()
    {
        $this->markTestIncomplete();
    }

    public function test_it_cannot_execute_recover_password()
    {
        $this->markTestIncomplete();
    }

    public function test_it_can_execute_reset_password()
    {
        $this->markTestIncomplete();
    }

    public function test_it_cannot_execute_reset_password()
    {
        $this->markTestIncomplete();
    }

}