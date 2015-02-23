<?php namespace Devise\Users;

use Mockery as m;

class UsersRepositoryTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->Framework = m::mock('Devise\Support\Framework');
        $this->Framework->Auth = m::mock('Illuminate\Auth\Guard');
        $this->UsersRepository = new UsersRepository(new \DvsUser, $this->Framework);
    }

    public function test_it_can_retrieve_current_user()
    {
        $this->Framework->Auth->shouldReceive('id')->andReturn(1);

        $output = $this->UsersRepository->retrieveCurrentUser();

        assertInstanceOf('DvsUser', $output);
        assertEquals(1, count($output));
    }

    public function test_it_can_retrieve_current_user_id()
    {
        $this->Framework->Auth->shouldReceive('id')->andReturn(1);

        $output = $this->UsersRepository->retrieveCurrentUserId();

        assertEquals(1, count($output));
    }

    public function test_it_can_get_paginated_list_of_users()
    {
        $output = $this->UsersRepository->users();

        assertCount(1, $output); // 1 users in seeds
    }

    public function test_it_can_get_user_with_find_by_id()
    {
        $output = $this->UsersRepository->findById(1);

        assertEquals(1, $output->id);
    }

    public function test_it_can_get_user_with_find_by_email()
    {
        $output = $this->UsersRepository->findByEmail('noreply@devisephp.com');

        assertEquals('noreply@devisephp.com', $output->email);
    }

    public function test_it_can_get_user_with_find_by_name()
    {
        $output = $this->UsersRepository->findByName('Devise Administrator');

        assertEquals('Devise Administrator', $output->name);
    }

    public function test_it_can_get_user_with_find_by_username()
    {
        $output = $this->UsersRepository->findByUsername('deviseadmin');

        assertEquals('deviseadmin', $output->username);
    }

}