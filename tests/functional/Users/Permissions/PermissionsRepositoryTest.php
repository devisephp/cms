<?php namespace Devise\Users\Permissions;

use Mockery as m;

class PermissionsRepositoryTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->Framework =  new \Devise\Support\Framework;
        $this->Framework->Config = m::mock('Illuminate\Config\Repository');
        $this->Framework->Input = m::mock('Illuminate\Http\Request');
        $this->Framework->View = m::mock('Illuminate\View\Factory');
        $this->Framework->Paginator = m::mock('Devise\Support\DevisePaginator');

        $this->PermissionsRepository = new PermissionsRepository($this->Framework);
    }

    public function test_it_can_get_all_permissions()
    {
        // gets a permissions config fixture (of what we expect bacl)
        $permissionsFixture = $this->fixture('devise-configs.permissions');

        $this->Framework->Config->shouldReceive('get')->once()->andReturn($permissionsFixture);

        assertArrayHasKey('isDeviseAdmin', $this->PermissionsRepository->getAllPermissions());
    }

    public function test_it_can_get_permission_by_path()
    {
        $this->markTestIncomplete();
    }

    public function test_it_can_get_permission_source_by_path()
    {
        $this->markTestIncomplete();
    }

    public function test_it_can_get_available_rules_list()
    {
        $this->markTestIncomplete();
    }

    public function test_it_can_get_rule_param_map()
    {
        $this->markTestIncomplete();
    }
}