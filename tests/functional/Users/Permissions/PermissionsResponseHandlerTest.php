<?php namespace Devise\Users\Permissions;

use Mockery as m;

class PermissionsResponseHandlerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->Framework = new \Devise\Support\Framework;
        $this->Framework->Redirect = m::mock('Illuminate\Routing\Redirector');
        $this->PermissionsManager = m::mock('Devise\Users\Permissions\PermissionsManager');
        $this->PermissionsResponseHandler = new PermissionsResponseHandler($this->PermissionsManager, $this->Framework);
    }

    public function test_it_can_successfully_execute_store()
    {
        $this->PermissionsManager->shouldReceive('storePermission')->once()->andReturnSelf();

        $this->Framework->Redirect
            ->shouldReceive('route')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('with')
            ->andReturn('Permission registered successfully');

        $output = $this->PermissionsResponseHandler->executeStore(['foo' => 'value']);

        assertEquals('Permission registered successfully', $output);
    }

    public function test_it_can_fail_and_validate_execute_store()
    {
        $this->PermissionsManager->shouldReceive('storePermission')->once()->andReturn(false);

        $this->Framework->Redirect
            ->shouldReceive('route')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('withInput', 'withErrors')
            ->andReturnSelf()
            ->shouldReceive('with')
            ->andReturn('There were validation errors');

        $output = $this->PermissionsResponseHandler->executeStore(['foo' => 'value']);

        assertEquals('There were validation errors', $output);
    }

    public function test_it_can_successfully_execute_update()
    {
        $this->PermissionsManager
            ->shouldReceive('updatePermission')
            ->once()
            ->andReturnSelf();

        $this->Framework->Redirect
            ->shouldReceive('route')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('with')
            ->andReturn('Permission updated succesfully');

        $output = $this->PermissionsResponseHandler->executeUpdate(['foo' => 'value']);

        assertEquals('Permission updated succesfully', $output);
    }

    public function test_it_can_fail_and_validate_execute_update()
    {
        $this->PermissionsManager->shouldReceive('updatePermission')->once()->andReturn(false);

        $this->Framework->Redirect
            ->shouldReceive('route')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('withInput', 'withErrors')
            ->andReturnSelf()
            ->shouldReceive('with')
            ->andReturn('There were validation errors');

        $input = ['foo' => 'value', 'permission_name_edit' => 'fooPermissionName'];

        $output = $this->PermissionsResponseHandler->executeUpdate($input);

        assertEquals('There were validation errors', $output);
    }

    public function test_it_can_successfully_execute_destroy()
    {
        $this->PermissionsManager
            ->shouldReceive('destroyPermission')
            ->once()
            ->andReturnSelf();

        $this->Framework->Redirect
            ->shouldReceive('route')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('with')
            ->andReturn('Permission deleted succesfully');

        $output = $this->PermissionsResponseHandler->executeDestroy(['condition' => 'someCondition']);

        assertEquals('Permission deleted succesfully', $output);
    }

    public function test_it_can_fail_and_validate_execute_destroy()
    {
        $this->PermissionsManager->shouldReceive('destroyPermission')->once()->andReturn(false);

        $this->Framework->Redirect
            ->shouldReceive('route', 'withErrors')
            ->once()
            ->andReturnSelf()
            ->shouldReceive('with')
            ->andReturn('There were validation errors');

        $input = ['foo' => 'value', 'permission_name_edit' => 'fooPermissionName'];

        $output = $this->PermissionsResponseHandler->executeDestroy($input);

        assertEquals('There were validation errors', $output);
    }
}