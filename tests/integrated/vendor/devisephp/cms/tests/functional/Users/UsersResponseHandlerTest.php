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
        $this->Framework->URL = m::mock('Illuminate\Routing\UrlGenerator');
        $this->UsersResponseHandler = new UsersResponseHandler($this->SessionsRepository, $this->UserManager, $this->Framework);
    }

    public function test_it_can_request_logout()
    {
        $this->SessionsRepository->shouldReceive('logout')->andReturn(true);
        $this->Framework->Redirect->shouldReceive('route')->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('with')->once()->andReturnSelf();

        $this->UsersResponseHandler->requestLogout();
    }

    public function test_it_cannot_request_login()
    {
        $this->SessionsRepository->shouldReceive('login')->once()->andReturn(false);
        $this->Framework->Redirect->shouldReceive('route')->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('withInput')->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('withErrors')->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('with')->once()->andReturnSelf();
        $this->UsersResponseHandler->requestLogin(['foo' => 'input data']);
    }

    public function test_it_can_request_login()
    {
        $this->SessionsRepository->shouldReceive('login')->once()->andReturn(true);
        $this->Framework->Redirect->shouldReceive('route')->once()->andReturnSelf();
        $this->UsersResponseHandler->requestLogin(['foo' => 'input data']);
    }

    public function test_it_can_request_login_with_an_intended_redirect()
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
        $this->UserManager->shouldReceive('registerUser')->once()->andReturn(new \DvsUser);

        $this->SessionsRepository->shouldReceive('sendActivationEmail')->once()->andReturn(true);

        $this->Framework->Redirect->shouldReceive('route')->once()->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('with')->once()->andReturn('Activation email sent');

        $output = $this->UsersResponseHandler->requestRegister(['foo' => 'input']);

        assertEquals('Activation email sent', $output);
    }

    public function test_it_cannot_request_register()
    {
        $this->UserManager->shouldReceive('registerUser')->andReturn(false);

        $this->Framework->Redirect->shouldReceive('route', 'withInput', 'withErrors')->once()->andReturnSelf();

        $this->UserManager->message = 'No activation email sent';

        $this->Framework->Redirect->shouldReceive('with')->once()->andReturn($this->UserManager->message);

        $output = $this->UsersResponseHandler->requestRegister(['foo' => 'input']);

        assertEquals('No activation email sent', $output);
    }

    public function test_it_can_request_activation()
    {
        $this->SessionsRepository->shouldReceive('activate')->once()->andReturn(true);

        $this->SessionsRepository->message = 'Account successfully activated';

        $this->Framework->Redirect->shouldReceive('route')->once()->andReturnSelf();

        $this->Framework->Redirect->shouldReceive('with')->once()->andReturn($this->SessionsRepository->message);

        $output = $this->UsersResponseHandler->requestActivation(1, 'AsdaASDAW82323123131');

        assertEquals('Account successfully activated', $output);
    }

    public function test_it_cannot_request_activation()
    {
        $this->SessionsRepository->shouldReceive('activate')->once()->andReturn(false);

        $this->Framework->Redirect->shouldReceive('route', 'withInput', 'withErrors')->once()->andReturnSelf();

        $this->SessionsRepository->message = 'Issues occurred while attempting to activate account';

        $this->Framework->Redirect->shouldReceive('with')->once()->andReturn($this->SessionsRepository->message);

        $output = $this->UsersResponseHandler->requestActivation(1, 'AsdaASDAW82323123131');

        assertEquals('Issues occurred while attempting to activate account', $output);
    }

    public function test_it_can_execute_recover_password()
    {
        $this->SessionsRepository->shouldReceive('recoverPassword')->once()->andReturn(true);

        $this->SessionsRepository->message = 'Recovery email has been sent';

        $this->Framework->Redirect
            ->shouldReceive('route')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('with')
            ->once()
            ->andReturn($this->SessionsRepository->message);

        $output = $this->UsersResponseHandler->requestRecoverPassword(['foo' => 'input']);

        assertEquals('Recovery email has been sent', $output);
    }

    public function test_it_cannot_execute_recover_password()
    {
        $this->SessionsRepository->shouldReceive('recoverPassword')->once()->andReturn(false);

        $this->SessionsRepository->message = 'There were validation errors';

        $this->Framework->Redirect
            ->shouldReceive('route', 'withInput', 'withErrors')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('with')
            ->once()
            ->andReturn($this->SessionsRepository->message);

        $output = $this->UsersResponseHandler->requestRecoverPassword(['foo' => 'input']);

        assertEquals('There were validation errors', $output);
    }

    public function test_it_can_execute_reset_password()
    {
        $this->SessionsRepository
            ->shouldReceive('resetPassword')
            ->once()
            ->andReturn(true);

        $this->SessionsRepository->message = 'Password successfully changed';

        $this->Framework->Redirect
            ->shouldReceive('route')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('with')
            ->once()
            ->andReturn($this->SessionsRepository->message);

        $output = $this->UsersResponseHandler->requestResetPassword(['foo' => 'input']);

        assertEquals('Password successfully changed', $output);
    }

    public function test_it_cannot_execute_reset_password()
    {
        $this->SessionsRepository
            ->shouldReceive('resetPassword')
            ->once()
            ->andReturn(false);

        $input = [
            'foo' => 'inputValue',
            'token' => 'AsdaASDAW82323123131'
        ];

        $this->Framework->URL
            ->shouldReceive('route')
            ->once()
            ->andReturnSelf();

        $this->SessionsRepository->message = 'There were validation errors';

        $this->Framework->Redirect
            ->shouldReceive('to','withInput','withErrors')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('with')
            ->once()
            ->andReturn($this->SessionsRepository->message);

        $output = $this->UsersResponseHandler->requestResetPassword($input);

        assertEquals('There were validation errors', $output);
    }

}