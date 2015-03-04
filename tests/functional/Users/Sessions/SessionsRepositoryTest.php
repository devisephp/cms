<?php namespace Devise\Users\Sessions;

use Mockery as m;

class SessionsRepositoryTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->DvsUser = new \DvsUser;
        $this->UserManager = m::mock('Devise\Users\UserManager');
        $this->UsersRepository = m::mock('Devise\Users\UsersRepository');

        // $this->Framework = m::mock('Devise\Support\Framework');
        $this->Framework = new \Devise\Support\Framework;
        $this->Framework->Auth = m::mock('Illuminate\Auth\Guard');
        $this->Framework->Hash = m::mock('Illuminate\Hashing\BcryptHasher');
        $this->Framework->Lang = m::mock('Illuminate\Translation\Translator');
        $this->Framework->Validator = m::mock('Illuminate\Validation\Factory');
        $this->Framework->Password = m::mock('Illuminate\Auth\Reminders\PasswordBroker');

        $this->SessionsRepository = new SessionsRepository($this->DvsUser, $this->UserManager, $this->UsersRepository, $this->Framework);
    }

    public function test_it_can_login_using_username()
    {
        $this->Framework->Auth
            ->shouldReceive('attempt')
            ->once()
            ->andReturn(true);

        $this->UsersRepository
            ->shouldReceive('findByUsername')
            ->once()
            ->andReturn($this->DvsUser);

        $input = [
            'uname_or_email' => 'deviseadmin',
            'password' => 'secret',
        ];

        $output = $this->SessionsRepository->login($input);

        assertInstanceOf('DvsUser', $output);
    }

    public function test_it_can_login_using_email()
    {
        $this->Framework->Auth
            ->shouldReceive('attempt')
            ->once()
            ->andReturn(true);

        $this->UsersRepository
            ->shouldReceive('findByUsername')
            ->andReturnSelf()
            ->shouldReceive('findByEmail')
            ->andReturn($this->DvsUser);

        $input = [
            'uname_or_email' => 'noreply@devisephp.com',
            'password' => 'secret',
        ];

        $output = $this->SessionsRepository->login($input);

        // check value of SessionsRepository message attribute
        assertEquals('You have been logged in.', $this->SessionsRepository->message);
    }

    public function test_it_cannot_login()
    {
        $this->Framework->Auth
            ->shouldReceive('attempt')
            ->times(2)
            ->andReturn(false);

        $input = [
            'uname_or_email' => 'foo@email.com',
            'password' => 'secret',
        ];

        assertFalse( $this->SessionsRepository->login($input) );
    }

    public function test_it_can_logout()
    {
        $this->Framework->Auth->shouldReceive('logout')->once()->andReturnSelf();

        assertTrue( $this->SessionsRepository->logout() );
    }

    public function test_it_can_recover_password()
    {
        $input = [
            '_token' => 'someFooTokenJASdad',
            'email' => 'foo@email.com'
        ];

        $this->Framework->Password
            ->shouldReceive('sendResetLink')
            ->andReturn('passwords.sent');

        // check null is returned
        assertNull( $this->SessionsRepository->recoverPassword($input) );

        // check SessionsRepo messages attribute equals string
        assertEquals( 'Recovery email has been sent.', $this->SessionsRepository->message );
    }

    public function test_it_cannot_recover_password()
    {
        $input = [
            '_token' => 'someFooTokenJASdad',
            'email' => 'foo@email.com'
        ];

        $this->Framework->Password
            ->shouldReceive('sendResetLink')
            ->once()
            ->andReturn(true);

        $this->Framework->Lang
            ->shouldReceive('get')
            ->once()
            ->andReturnSelf();

        assertFalse( $this->SessionsRepository->recoverPassword($input) );
    }

    public function test_it_cannot_reset_password()
    {
        $input = [
            '_token' => 'someFooTokenJASdad',
            'email' => 'foo@email.com'
        ];

        $this->Framework->Password
            ->shouldReceive('reset')
            ->once()
            ->andReturn('passwords.password');

        $this->Framework->Lang
            ->shouldReceive('get')
            ->once()
            ->andReturnSelf();

        $output = $this->SessionsRepository->resetPassword($input);

        assertEquals('There were validation errors.', $this->SessionsRepository->message);
    }

    public function test_it_can_activate()
    {
        $this->UsersRepository
            ->shouldReceive('findById')
            ->once()
            ->andReturn($this->DvsUser);

        // will match the hash passed in
        $this->DvsUser->activate_code = 'AbCDeFGhIJkLMnOP';

        $this->UserManager
            ->shouldReceive('activate')
            ->once()
            ->andReturnSelf();

        $this->Framework->Auth
            ->shouldReceive('login')
            ->once()
            ->andReturn($this->DvsUser);

        assertTrue($this->SessionsRepository->activate(1, 'AbCDeFGhIJkLMnOP'));
    }

    public function test_it_cannot_activate()
    {
        $this->UsersRepository
            ->shouldReceive('findById')
            ->once()
            ->andReturn($this->DvsUser);

        // will not match hash passed in
        $this->DvsUser->activate_code = 'NoTGoIngToMatch';

        assertFalse($this->SessionsRepository->activate(1, 'AbCDeFGhIJkLMnOP'));
    }

    public function test_it_can_send_activation_email()
    {
        $this->Framework->Mail = m::mock('Illuminate\Mail\Mailer');

        $this->Framework->Mail
            ->shouldReceive('send')
            ->once()
            ->andReturnSelf();

        assertTrue($this->SessionsRepository->sendActivationEmail($this->DvsUser));
    }

    public function test_it_cannot_send_activation_email()
    {
        $this->DvsUser->activated = true; // this will make it fail

        assertFalse($this->SessionsRepository->sendActivationEmail($this->DvsUser));
    }

    public function test_it_can_validate_credentials()
    {
        $this->Framework->Auth
            ->shouldReceive('validate')
            ->once()
            ->andReturn(true);

        $credentials = [
            'email' => 'noreply@devisephp.com',
            'password' => 'secret',
        ];

        assertTrue( $this->SessionsRepository->validateCredentials($credentials) );
    }

    public function test_it_can_get_remember_me()
    {
        assertTrue( $this->SessionsRepository->getRememberMe(['remember_me' => 1]) );
    }

    public function test_it_cannot_get_remember_me()
    {
        assertFalse( $this->SessionsRepository->getRememberMe(['foo' => 'input']) );
    }
}