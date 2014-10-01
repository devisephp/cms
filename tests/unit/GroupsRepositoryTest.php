<?php

use Devise\User\Repositories\GroupsRepository;
use Mockery as m;

class GroupsRepositoryTest extends Orchestra\Testbench\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * Test store method is successful with valid input data
     */
    public function testStoreSuccessfulWithValidInputData()
    {
        $mockValidator = m::mock('Illuminate\Validation\Factory');
        $mockValidator->shouldReceive('make')
            ->once()
            ->andReturn($mockValidator)
            ->shouldReceive('fails')
            ->once()
            ->andReturn(false);

        // swap instance of Validator with mockValidator
        Validator::swap($mockValidator);

        $mockGroup = m::mock('Group');
        $mockGroup->shouldReceive('setAttribute')
            ->once()
            ->andReturn(true)
            ->shouldReceive('save')
            ->once()
            ->andReturn(true);

        $GroupsRepository = new GroupsRepository($mockGroup);
        $result = $GroupsRepository->store(array('name' => 'Yolanda Johnson'));

        // Check for success message and an instance of Group object is returned
        $this->assertEquals($GroupsRepository->message, 'Group successfully created.');
        $this->assertInstanceOf('Group', $result);
    }

    /**
     * Test store method fails with invalid input data
     */
    public function testStoreFailsWithInvalidInputData()
    {
        $mockGroup = m::mock('Group');
        $mockMessageBag = m::mock('Illuminate\Support\MessageBag');

        $mockValidator = m::mock('Illuminate\Validation\Factory');
        $mockValidator->shouldReceive('make')
            ->once()
            ->andReturn($mockValidator)
            ->shouldReceive('fails')
            ->once()
            ->andReturn(true)
            ->shouldReceive('errors')
            ->once()
            ->andReturn($mockMessageBag);

        $mockMessageBag->shouldReceive('all')
            ->once()
            ->andReturn($mockGroup->messages);

        // swap instance of Validator with mockValidator
        Validator::swap($mockValidator);

        // Execute store method with invalid input data
        $GroupsRepository = new GroupsRepository($mockGroup);
        $result = $GroupsRepository->store(array('name' => ''));

        $this->assertEquals($GroupsRepository->message, 'There were validation errors.');
        $this->assertFalse($result);
    }

    /**
     * Test update method successful with valid input data
     */
    public function testUpdateSuccessfulWithValidInputData()
    {
        $validGroupId = 1;

        $mockValidator = m::mock('Illuminate\Validation\Factory');
        $mockValidator->shouldReceive('make')
            ->once()
            ->andReturn($mockValidator)
            ->shouldReceive('fails')
            ->once()
            ->andReturn(false);

        // swap instance of Validator with mockValidator
        Validator::swap($mockValidator);

        $mockGroup = m::mock('Group');
        $mockGroup->shouldReceive('with')
            ->once()
            ->andReturn(m::self())
            ->shouldReceive('findOrFail')
            ->once()
            ->andReturn(m::self())
            ->shouldReceive('setAttribute')
            ->once()
            ->andReturn(true)
            ->shouldReceive('save')
            ->once()
            ->andReturn(true);

        $GroupsRepository = new GroupsRepository($mockGroup);
        $result = $GroupsRepository->update($validGroupId, array('name' => 'Yolanda Johnson'));

        // Check for success message and an instance of Group object is returned
        $this->assertEquals($GroupsRepository->message, 'Group successfully updated.');
        $this->assertInstanceOf('Group', $result);
    }

    /**
     * Test update method fails with invalid input data
     */
    public function testUpdateFailsWithInvalidInputData()
    {
        $mockGroup = m::mock('Group');
        $mockMessageBag = m::mock('Illuminate\Support\MessageBag');

        $mockValidator = m::mock('Illuminate\Validation\Factory');
        $mockValidator->shouldReceive('make')
            ->once()
            ->andReturn($mockValidator)
            ->shouldReceive('fails')
            ->once()
            ->andReturn(true)
            ->shouldReceive('errors')
            ->once()
            ->andReturn($mockMessageBag);

        $mockMessageBag->shouldReceive('all')
            ->once()
            ->andReturn($mockGroup->messages);

        // swap Validator with mockValidator instance
        Validator::swap($mockValidator);

        // Execute store method using invalid input data
        $GroupsRepository = new GroupsRepository($mockGroup);
        $result = $GroupsRepository->update(1, array('name' => ''));

        $this->assertEquals($GroupsRepository->message, 'There were validation errors.');
        $this->assertFalse($result);
    }

    /**
     * Test destroy method fails with invalid group id
     */
    public function testDestroyFailsWithInvalidId()
    {
        $group = m::mock('Group');
        $group->shouldReceive('with')
            ->once()
            ->andReturn(m::self())
            ->shouldReceive('findOrFail')
            ->once()
            ->andReturn(null);

        $GroupsRepository = new GroupsRepository($group);
        $result = $GroupsRepository->destroy(null);

        $this->assertEquals($GroupsRepository->message, 'Group could not be removed. Please, try again.');
        $this->assertFalse($result);
    }

    /**
     * Test destroy method is successful with valid group id
     */
    public function testDestroySuccessfulWithValidId()
    {
        $group = m::mock('Group');
        $group->shouldReceive('with')
            ->once()
            ->andReturn(m::self())
            ->shouldReceive('findOrFail')
            ->once()
            ->andReturn(m::self())
            ->shouldReceive('delete')
            ->once()
            ->andReturn(true);

        $GroupsRepository = new GroupsRepository($group);
        $result = $GroupsRepository->destroy(1);

        $this->assertEquals($GroupsRepository->message, 'Group successfully removed.');
        $this->assertTrue($result);
    }
}