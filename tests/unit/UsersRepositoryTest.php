<?php

use Devise\User\Repositories\UsersRepository;
use Mockery as m;

class UsersRepositoryTest extends Orchestra\Testbench\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * Test findByEmail method fails with non-existent email
     */
    public function testFindByEmailFailsWithNonExistentEmail()
    {
        $mockUser = m::mock('User');
        $mockUser->shouldReceive('with')
            ->andReturn(m::self())
            ->shouldReceive('whereEmail')
            ->andReturn(m::self())
            ->shouldReceive('first')
            ->andReturnNull();

        $UsersRepository = new UsersRepository($mockUser);
        $result = $UsersRepository->findByEmail('');

        // Check returned value of null
        $this->assertNull($result);
    }

    /**
     * Test store method is successful with valid input data
     */
    public function testStoreSuccessfulWithValidInputData()
    {
        $mockValidator = m::mock('Illuminate\Validation\Factory');
        $mockValidator->shouldReceive('make')
            ->andReturn($mockValidator)
            ->shouldReceive('fails')
            ->andReturn(false);

         Validator::swap($mockValidator);

        $mockUser = m::mock('User');
        $mockUser->shouldReceive('setAttribute')
            ->andReturn(true)
            ->shouldReceive('save')
            ->andReturn(true)
            ->shouldReceive('groups')
            ->andReturn(m::self())
            ->shouldReceive('attach')
            ->andReturn(null);

        $input = array(
            'group_id' => 1,
            'email' => 'yolanda@lbm.co',
            'password' => 'testingpass'
        );

        Mail::shouldReceive('send')
            ->once()
            ->andReturn($mockUser);

        $UsersRepository = new UsersRepository($mockUser);
        $result = $UsersRepository->store($input);

        // Check for success message and an instance of User object is returned
        $this->assertEquals($UsersRepository->message, 'User successfully created. Check email to complete activation process.');
        $this->assertInstanceOf('User', $result);
    }

    /**
     * Test store method fails with invalid input data
     */
    public function testStoreFailsWithInvalidInputData()
    {
        $mockUser = m::mock('User');
        $mockMessageBag = m::mock('Illuminate\Support\MessageBag');
        $mockValidator = m::mock('Illuminate\Validation\Factory');
        $mockValidator->shouldReceive('make')
            ->andReturn($mockValidator)
            ->shouldReceive('fails')
            ->andReturn(true)
            ->shouldReceive('errors')
            ->andReturn($mockMessageBag);

        $mockMessageBag->shouldReceive('all')
            ->andReturn($mockUser->messages);

        Validator::swap($mockValidator);

        $UsersRepository = new UsersRepository($mockUser);
        $result = $UsersRepository->store(array());

        // Check for validation fail message and false is returned
        $this->assertEquals($UsersRepository->message, 'There were validation errors.');
        $this->assertFalse($result);
    }

    /**
     * Test update method is successful with valid input data
     */
    public function testUpdateSuccessfulWithValidInputData()
    {
        $mockValidator = m::mock('Illuminate\Validation\Factory');
        $mockValidator->shouldReceive('make')
            ->andReturn($mockValidator)
            ->shouldReceive('fails')
            ->once()
            ->andReturn(false);

        Validator::swap($mockValidator);

        $mockUser = m::mock('User');
        $mockUser->shouldReceive('with')
            ->andReturn(m::self())
            ->shouldReceive('findOrFail')
            ->andReturn(m::self())
            ->shouldReceive('setAttribute')
            ->andReturn(true)
            ->shouldReceive('save')
            ->andReturn(true)
            ->shouldReceive('groups')
            ->andReturn(m::self())
            ->shouldReceive('sync')
            ->andReturn(true);

        $input = array(
            'group_id' => 1,
            'email' => 'yolanda@lbm.co',
            'password' => 'testingpass'
        );

        $UsersRepository = new UsersRepository($mockUser);
        $result = $UsersRepository->update(1, $input);

        // Check for success validation message and the returned object is a User instance
        $this->assertEquals($UsersRepository->message, 'User successfully updated.');
        $this->assertInstanceOf('User', $result);
    }

    /**
     * Test update method fails with invalid input data
     */
    public function testUpdateFailsWithInvalidInputData()
    {
        $mockUser = m::mock('User');
        $mockMessageBag = m::mock('Illuminate\Support\MessageBag');
        $mockValidator = m::mock('Illuminate\Validation\Factory');
        $mockValidator->shouldReceive('make')
            ->andReturn($mockValidator)
            ->shouldReceive('fails')
            ->andReturn(true)
            ->shouldReceive('errors')
            ->andReturn($mockMessageBag);

        $mockMessageBag->shouldReceive('all')
            ->andReturn($mockUser->messages);

        Validator::swap($mockValidator);

        $UsersRepository = new UsersRepository($mockUser);
        $result = $UsersRepository->update('', array());

        // Check for failed validation message and false is returned
        $this->assertEquals($UsersRepository->message, 'There were validation errors.');
        $this->assertFalse($result);
    }

    /**
     * Test destroy method is successful with valid user id
     */
    public function testDestroySuccessfulWithValidId()
    {
        $mockUser = m::mock('User');
        $mockUser->shouldReceive('with')
            ->once()
            ->andReturn(m::self())
            ->shouldReceive('findOrFail')
            ->once()
            ->andReturn(m::self())
            ->shouldReceive('delete')
            ->once()
            ->andReturn(true);

        $UsersRepository = new UsersRepository($mockUser);
        $result = $UsersRepository->destroy(1);

        $this->assertEquals($UsersRepository->message, 'User successfully removed.');
        $this->assertTrue($result);
    }

    /**
     * Test destroy method fails with invalid user id
     */
    public function testDestroyFailsWithInvalidId()
    {
        $mockUser = m::mock('User');
        $mockUser->shouldReceive('with')
            ->once()
            ->andReturn(m::self())
            ->shouldReceive('findOrFail')
            ->once()
            ->andReturn(null);

        $UsersRepository = new UsersRepository($mockUser);
        $result = $UsersRepository->destroy(null);

        $this->assertEquals($UsersRepository->message, 'User could not be removed. Please, try again.');
        $this->assertFalse($result);
    }

    /**
     * Test activate method is successful with valid user instance
     */
    public function testActivateSuccessfulWithValidUserInstance()
    {
        $mockUser = m::mock('User');
        $mockUser->shouldReceive('with')
            ->andReturn(m::self())
            ->shouldReceive('findOrFail')
            ->andReturn(m::self())
            ->shouldReceive('setAttribute')
            ->andReturn(true)
            ->shouldReceive('save')
            ->andReturn(true);

        $UsersRepository = new UsersRepository($mockUser);
        $result = $UsersRepository->activate($mockUser);

        // Check the returned value is true for successful User save
        $this->assertTrue($result);
    }

    /**
     * Test activate method throws an error exception when supplied invalid User instance

     * @expectedException   ErrorException
     */
    public function testActivateThrowsErrorExceptionWithInvalidUserInstance()
    {
        $mockUser = m::mock('User');
        $UsersRepository = new UsersRepository($mockUser);
        $UsersRepository->activate(null);
    }

    /**
     * Test updatePassword method fails with invalid input data
     */
    public function testUpdatePasswordFailsWithInvalidInputData()
    {
        $mockUser = m::mock('User');
        $mockMessageBag = m::mock('Illuminate\Support\MessageBag');
        $mockValidator = m::mock('Illuminate\Validation\Factory');
        $mockValidator->shouldReceive('make')
            ->andReturn($mockValidator)
            ->shouldReceive('fails')
            ->andReturn(true)
            ->shouldReceive('errors')
            ->andReturn($mockMessageBag);

        $mockMessageBag->shouldReceive('all')
            ->andReturn($mockUser->messages);

        Validator::swap($mockValidator);

        $UsersRepository = new UsersRepository($mockUser);
        $result = $UsersRepository->updatePassword('', array());

        // Check for failed validation message and false value
        $this->assertEquals($UsersRepository->message, 'There were validation errors.');
        $this->assertFalse($result);
    }

    /**
     * Test updatePassword method fails validation when incorrect current password supplied
     */
    public function testUpdatePasswordFailsValidationWithIncorrectCurrentPassword()
    {
        $mockUser = m::mock('User');
        $mockUser->shouldReceive('with')
            ->andReturn(m::self())
            ->shouldReceive('findOrFail')
            ->andReturn(m::self())
            ->shouldReceive('checkPassword')
            ->andReturn(false);

        $mockValidator = m::mock('Illuminate\Validation\Factory');
        $mockValidator->shouldReceive('make')
            ->andReturn($mockValidator)
            ->shouldReceive('fails')
            ->andReturn(false);

        Validator::swap($mockValidator);

        $UsersRepository = new UsersRepository($mockUser);
        $result = $UsersRepository->updatePassword(1, array('current_password' => 'password'));

        // Check for failed validation message and false value
        $this->assertEquals($UsersRepository->message, 'Current password was incorrect. Please, try again.');
        $this->assertFalse($result);
    }

    /**
     * Test updatePassword method is successful with valid input data. The value for
     * "Email Updated Password?" has not been checked so no email is sent
     */
    public function testUpdatePasswordSuccessfulWithValidInputDataAndNoEmailOfUpdatedPassword()
    {
        $mockValidator = m::mock('Illuminate\Validation\Factory');
        $mockValidator->shouldReceive('make')
            ->andReturn($mockValidator)
            ->shouldReceive('fails')
            ->once()
            ->andReturn(false);

        Validator::swap($mockValidator);

        $mockUser = m::mock('User');
        $mockUser->shouldReceive('with')
            ->andReturn(m::self())
            ->shouldReceive('findOrFail')
            ->andReturn(m::self())
            ->shouldReceive('checkPassword')
            ->andReturn(true)
            ->shouldReceive('setAttribute')
            ->andReturn(true)
            ->shouldReceive('save')
            ->andReturn(true);

        $input = array(
            '_method' => 'PUT',
            'current_password' => 'currentpassword',
            'new_password' => 'newpassword',
            'new_password_confirmation' => 'newpassword'
        );

        $UsersRepository = new UsersRepository($mockUser);
        $result = $UsersRepository->updatePassword(1, $input);

        // Check for success validation message and the returned object is a User instance
        $this->assertEquals($UsersRepository->message, 'Password successfully updated.');
        $this->assertTrue($result);
    }

    /**
     * Test updatePassword method is successful with valid input data.
     * "Email Updated Password?" has not been checked so no email is sent
     */
    public function testUpdatePasswordSuccessfulWithValidInputDataAndEmailUpdatedPassword()
    {
        $mockValidator = m::mock('Illuminate\Validation\Factory');
        $mockValidator->shouldReceive('make')
            ->andReturn($mockValidator)
            ->shouldReceive('fails')
            ->once()
            ->andReturn(false);

        Validator::swap($mockValidator);

        $mockUser = m::mock('User');
        $mockUser->shouldReceive('with')
            ->andReturn(m::self())
            ->shouldReceive('findOrFail')
            ->andReturn(m::self())
            ->shouldReceive('checkPassword')
            ->andReturn(true)
            ->shouldReceive('setAttribute')
            ->andReturn(true)
            ->shouldReceive('save')
            ->andReturn(true);

        $input = array(
            '_method' => 'PUT',
            'current_password' => 'currentpassword',
            'new_password' => 'newpassword',
            'new_password_confirmation' => 'newpassword',
            'email_updated_password' => true
        );

        Mail::shouldReceive('send')
            ->andReturn($mockUser);

        $UsersRepository = new UsersRepository($mockUser);
        $result = $UsersRepository->updatePassword(1, $input);

        // Check for success validation message and the returned object is a User instance
        $this->assertEquals($UsersRepository->message, 'Password successfully updated.');
        $this->assertTrue($result);
    }

    /**
     * Test generateActivateCode method is successful with valid User instance
     */
    public function testGenerateActivateCodeSuccessfulWithValidUserInstance()
    {
        $mockUser = m::mock('User');
        $mockUser->shouldReceive('with')
            ->andReturn(m::self())
            ->shouldReceive('findOrFail')
            ->andReturn(m::self())
            ->shouldReceive('setAttribute')
            ->andReturn(true)
            ->shouldReceive('save')
            ->andReturn(true);

        $UsersRepository = new UsersRepository($mockUser);
        $result = $UsersRepository->activate($mockUser);

        // Check the returned value is true which indicates
        // an activate code was successfully generated
        $this->assertTrue($result);
    }

    /**
     * Test generateActivateCode method throws ErrorException with invalid User instance
     *
     * @expectedException   ErrorException
     */
    public function testGenerateActivateCodeThrowsErrorExceptionWithInvalidUserInstance()
    {
        $mockUser = m::mock('User');
        $UsersRepository = new UsersRepository($mockUser);
        $UsersRepository->generateActivateCode('');
    }
}
