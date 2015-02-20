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

        $this->Framework = m::mock('Devise\Support\Framework');
        $this->Framework->Auth = m::mock('Illuminate\Auth\Guard');
        $this->Framework->Hash = m::mock('Illuminate\Hashing\BcryptHasher');
        $this->Framework->Lang = m::mock('Illuminate\Translation\Translator');
        $this->Framework->Validator = m::mock('Illuminate\Validation\Factory');

        $this->SessionsRepository = new SessionsRepository($this->DvsUser, $this->UserManager, $this->UsersRepository, $this->Framework);
    }

    public function test_it_can_login()
    {
        $this->Framework->Auth
            ->shouldReceive('attempt')
            ->once()
            ->andReturn(true);

        $this->UsersRepository
            ->shouldReceive('findByEmail')
            ->once()
            ->andReturn($this->DvsUser);

        $input = [
            'email' => 'foo@email.com',
            'password' => 'secret',
        ];

        $output = $this->SessionsRepository->login($input);

        assertInstanceOf('DvsUser', $output);
    }

    public function test_it_cannot_login()
    {
        $this->Framework->Auth
            ->shouldReceive('attempt')
            ->once()
            ->andReturn(false);

        $input = [
            'email' => 'foo@email.com',
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
        $this->markTestIncomplete();
    }

    public function test_it_can_reset_password()
    {
        $this->markTestIncomplete();
    }

    public function test_it_can_activate()
    {
        $this->markTestIncomplete();
    }

    public function test_it_cannot_activate()
    {
        $this->markTestIncomplete();
    }

    public function test_it_can_send_activation_email()
    {
        $this->markTestIncomplete();
    }

    public function test_it_can_validate_credentials()
    {
        $this->markTestIncomplete();
    }

    public function test_it_can_get_remember_me()
    {
        $this->markTestIncomplete();
    }
}