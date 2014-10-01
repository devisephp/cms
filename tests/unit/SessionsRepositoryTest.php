<?php

use Devise\User\Repositories\SessionsRepository;
use Mockery as m;

class SessionsRepositoryTest extends Orchestra\Testbench\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * Test login method is successful with valid input data
     */
    public function testLoginSuccessfulWithValidData()
    {
        $mockValidator = m::mock('Illuminate\Validation\Factory');
        $mockValidator->shouldReceive('make')
            ->andReturnSelf()
            ->shouldReceive('fails')
            ->andReturn(false);

        Validator::swap($mockValidator);

        $mockUsersRepository = m::mock('Devise\User\Repositories\UsersRepository');
        $mockUsersRepository->shouldReceive('findByEmail')
            ->andReturnSelf();

        Auth::shouldReceive('attempt')
            ->andReturn(true);

        $input = array(
            'email' => 'yolanda@lbm.co',
            'password' => 'pass1234',
            'remember_me' => false
        );

        $SessionsRepository = new SessionsRepository(m::mock('User'), $mockUsersRepository);
        $result = $SessionsRepository->login($input);

        // Check for success message and value returned is of the type object
        $this->assertEquals($SessionsRepository->message, 'You have been logged in.');
        $this->assertInternalType('object', $result);
    }


    /**
     * Test login method passes validation of input but fails to login
     * due to invalid credentials
     */
    public function testLoginPassesInputValidationButFailsAuthAttempt()
    {
        $mockValidator = m::mock('Illuminate\Validation\Factory');
        $mockValidator->shouldReceive('make')
            ->andReturnSelf()
            ->shouldReceive('fails')
            ->andReturn(false);

        Validator::swap($mockValidator);

        $mockUsersRepository = m::mock('Devise\User\Repositories\UsersRepository');
        $mockUsersRepository->shouldReceive('findByEmail')
            ->andReturnSelf();

        Auth::shouldReceive('attempt')
            ->andReturn(false);

        $input = array(
            'email' => 'yolanda@lbm.co',
            'password' => 'pass1234',
            'remember_me' => true
        );

        $SessionsRepository = new SessionsRepository(m::mock('User'), $mockUsersRepository);
        $result = $SessionsRepository->login($input);

        // Check for fail message, errors and false value
        $this->assertEquals($SessionsRepository->message, 'There were validation errors.');
        $this->assertEquals($SessionsRepository->errors, 'Incorrect email and/or password. Please try again.');
        $this->assertFalse($result);
    }

    /**
     * Test login method fails model validation with invalid input data
     */
    public function testRegisterFailsModelValidationWithInvalidInputData()
    {
        $mockValidator = m::mock('Illuminate\Validation\Factory');
        $mockValidator->shouldReceive('make')
            ->andReturnSelf()
            ->shouldReceive('fails')
            ->andReturn(true)
            ->shouldReceive('errors')
            ->andReturnSelf()
            ->shouldReceive('all')
            ->andReturnSelf();

        Validator::swap($mockValidator);

        $SessionsRepository = new SessionsRepository(m::mock('User'), m::mock('Devise\User\Repositories\UsersRepository'));
        $result = $SessionsRepository->login(array());

        // Check for fail message and false value
        $this->assertEquals($SessionsRepository->message, 'There were validation errors.');
        $this->assertFalse($result);
    }

    /**
     * Test logout method is successful
     */
    public function testLogoutIsSuccessful()
    {
        $mockUser = m::mock('User');
        $mockUsersRepository = m::mock('Devise\User\Repositories\UsersRepository');

        $SessionsRepository = new SessionsRepository($mockUser, $mockUsersRepository);
        $result = $SessionsRepository->logout();

        // Check for logout success message and returned value is true
        $this->assertEquals($SessionsRepository->message, 'You have been logged out.');
        $this->assertTrue($result);
    }

    /**
     * Test register method is successful with invalid input data
     */
    public function testRegisterSuccessfulWithValidInputData()
    {
        $mockValidator = m::mock('Illuminate\Validation\Factory');
        $mockValidator->shouldReceive('make')
            ->andReturnSelf()
            ->shouldReceive('fails')
            ->andReturn(false);

        Validator::swap($mockValidator);

        $mockUsersRepository = m::mock('Devise\User\Repositories\UsersRepository');
        $mockUsersRepository->shouldReceive('store')
            ->andReturn(true);

        $input = array(
            '_token' => 'Zl1jInADS234324AWDiWIiOMjWItH1Cxrs2Z',
            'group_id' => '1',
            'email' => 'yolanda@lbm.co',
            'password' => 'pass1234',
            'password_confirmation' => 'pass1234'
        );

        $SessionsRepository = new SessionsRepository(m::mock('User'), $mockUsersRepository);
        $result = $SessionsRepository->register($input);

        // Check for success message and true value
        $this->assertEquals($SessionsRepository->message, 'User successfully created, check your email to complete the activation process.');
        $this->assertTrue($result);
    }

    /**
     * Test register method fails with invalid input data
     */
    public function testRegisterFailsWithInvalidInputData()
    {
        $mockValidator = m::mock('Illuminate\Validation\Factory');
        $mockValidator->shouldReceive('make')
            ->andReturnSelf()
            ->shouldReceive('fails')
            ->andReturn(true)
            ->shouldReceive('errors')
            ->andReturnSelf()
            ->shouldReceive('all')
            ->andReturnSelf();

        Validator::swap($mockValidator);

        $SessionsRepository = new SessionsRepository(m::mock('User'), m::mock('Devise\User\Repositories\UsersRepository'));
        $result = $SessionsRepository->register(array());

        // Check for fail message and false value
        $this->assertEquals($SessionsRepository->message, 'There were validation errors.');
        $this->assertFalse($result);
    }

    /**
     * Test resendActivation method is successful with valid data
     */
    public function testResendActivationSuccessfulWithValidData()
    {
        $mockValidator = m::mock('Illuminate\Validation\Factory');
        $mockValidator->shouldReceive('make')
            ->andReturnSelf()
            ->shouldReceive('fails')
            ->andReturn(false);

        Validator::swap($mockValidator);

        $mockUsersRepository = m::mock('Devise\User\Repositories\UsersRepository');
        $mockUsersRepository->shouldReceive('findByEmail')
            ->andReturnSelf()
            ->shouldReceive('isActivated')
            ->andReturn(false);

        Mail::shouldReceive('send')
            ->andReturn(true);

        $SessionsRepository = new SessionsRepository(m::mock('User'), $mockUsersRepository);
        $result = $SessionsRepository->resendActivation(array('email' => 'yolanda@lbm.co'));

        // Check for success message true value
        $this->assertEquals($SessionsRepository->message, 'Activation email sent, check your email to complete the activation process.');
        $this->assertTrue($result);
    }

    /**
     * Test resendActivation method passes validation but fails to resend email
     * because the User record has "activated" flag already set to true
     */
    public function testResendActivationPassesValidationButFailsResendDueToUserAlreadyActivated()
    {
        $mockValidator = m::mock('Illuminate\Validation\Factory');
        $mockValidator->shouldReceive('make')
            ->andReturnSelf()
            ->shouldReceive('fails')
            ->andReturn(false);

        Validator::swap($mockValidator);

        $mockUser = m::mock('User');

        $mockUsersRepository = m::mock('Devise\User\Repositories\UsersRepository');
        $mockUsersRepository->shouldReceive('findByEmail')
            ->andReturnSelf()
            ->shouldReceive('isActivated')
            ->andReturn(true);

        $SessionsRepository = new SessionsRepository($mockUser, $mockUsersRepository);
        $result = $SessionsRepository->resendActivation(array('email' => 'yolanda@lbm.co'));

        // Check for fail to resend message and false value
        $this->assertEquals($SessionsRepository->message, 'User has already been activated. No activation email sent.');
        $this->assertFalse($result);
    }

    /**
     * Test resendActivation method fails with invalid input data
     */
    public function testResendActivationFailsWithInvalidInputData()
    {
        $mockValidator = m::mock('Illuminate\Validation\Factory');
        $mockValidator->shouldReceive('make')
            ->andReturnSelf()
            ->shouldReceive('fails')
            ->andReturn(true)
            ->shouldReceive('errors')
            ->andReturnSelf()
            ->shouldReceive('all')
            ->andReturnSelf();

        Validator::swap($mockValidator);

        $SessionsRepository = new SessionsRepository(m::mock('User'), m::mock('Devise\User\Repositories\UsersRepository'));
        $result = $SessionsRepository->resendActivation(array());

        // Check for fail message and false value
        $this->assertEquals($SessionsRepository->message, 'There were validation errors.');
        $this->assertFalse($result);
    }

    /**
     * Test the activate method is successful when activate codes are equal
     */
    public function testActivateSuccessfulWhenActivateCodesAreEqual()
    {
        $mockUsersRepository = m::mock('Devise\User\Repositories\UsersRepository');
        $mockUsersRepository->shouldReceive('findById')
            ->andReturnSelf()
            ->shouldReceive('getActivateCode')
            ->andReturn('CorrectActivateCode')
            ->shouldReceive('activate')
            ->andReturn(true);

        // mock Auth::login
        Auth::shouldReceive('login')
            ->andReturn(true);

        $SessionsRepository = new SessionsRepository(m::mock('User'), $mockUsersRepository);
        $result = $SessionsRepository->activate(1, 'CorrectActivateCode');

        // Check for success message and true value
        $this->assertEquals($SessionsRepository->message, 'Account successfully activated.');
        $this->assertTrue($result);
    }

    /**
     * Test the activate method fails when the activate code being passed in
     * does not equal the value returned from UsersRepository getActivateCode method
     */
    public function testActivateFailsWhenActivateCodesAreNotEqual()
    {
        $mockUsersRepository = m::mock('Devise\User\Repositories\UsersRepository');
        $mockUsersRepository->shouldReceive('findById')
            ->andReturnSelf()
            ->shouldReceive('getActivateCode')
            ->andReturn('CorrectActivateCode');

        $SessionsRepository = new SessionsRepository(m::mock('User'), $mockUsersRepository);
        $result = $SessionsRepository->activate(1, 'IncorrectActivateCode');

        // Check for fail message and false value
        $this->assertEquals($SessionsRepository->message, 'Issues occurred while attempting to activate account. Please contact support.');
        $this->assertFalse($result);
    }

    /**
     * Test remove unactivated users method returns true when User records
     * are found and removed successfully
     */
    public function testRemoveUnactivatedUsersReturnsTrueWhenSuccessful()
    {
        $mockUser = m::mock('User');
        $mockUser->shouldReceive('where')
            ->andReturn(m::self())
            ->shouldReceive('forceDelete')
            ->andReturn(true);

        $mockUsersRepository = m::mock('Devise\User\Repositories\UsersRepository');

        $SessionsRepository = new SessionsRepository($mockUser, $mockUsersRepository);
        $result = $SessionsRepository->removeUnactivatedUsers();

        // Check for true value
        $this->assertTrue($result);
    }

    /**
     * Test remove unactivated users method returns false when no User records are found
     */
    public function testRemoveUnactivatedUsersReturnsFalseWhenNoRecordsFound()
    {
        $mockUser = m::mock('User');
        $mockUser->shouldReceive('where')
            ->andReturn(m::self())
            ->shouldReceive('forceDelete')
            ->andReturn(false);

        $SessionsRepository = new SessionsRepository($mockUser, m::mock('Devise\User\Repositories\UsersRepository'));
        $result = $SessionsRepository->removeUnactivatedUsers();

        // check for false value
        $this->assertFalse($result);
    }

    /**
     * Test getRememberMe method returns true when valid input supplied
     */
    public function testGetRememberMeReturnsTrueWithValidInputData()
    {
        $mockUser = m::mock('User');
        $mockUsersRepository = m::mock('Devise\User\Repositories\UsersRepository');

        $SessionsRepository = new SessionsRepository($mockUser, $mockUsersRepository);
        $result = $SessionsRepository->getRememberMe(array('remember_me' => true));

        // Check for true value
        $this->assertTrue($result);
    }

    /**
     * Test getRememberMe method returns false when input does not have "remember_me" key
     */
    public function testGetRememberMeReturnsFalseWhenInputHasNoRememberMeKey()
    {
        $mockUser = m::mock('User');
        $mockUsersRepository = m::mock('Devise\User\Repositories\UsersRepository');

        $SessionsRepository = new SessionsRepository($mockUser, $mockUsersRepository);
        $result = $SessionsRepository->getRememberMe(array());

        // Check for false value
        $this->assertFalse($result);
    }

}
