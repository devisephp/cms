<?php namespace Devise\Users\Permissions;

use Mockery as m;

class PermissionsRepositoryTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->Framework =  new \Devise\Support\Framework;

        $this->PermissionsRepository = new PermissionsRepository($this->Framework);
    }

    public function test_it_can_get_all_permissions()
    {
        assertArrayHasKey('isDeveloper', $this->PermissionsRepository->getAllPermissions());
    }

    public function test_it_cannot_get_permission_by_path()
    {
        $path = 'does.not.exist';

        $this->setExpectedException('Devise\Support\DeviseException', 'Unable to load the condition "'.$path.'".');
        $results = $this->PermissionsRepository->getPermissionByPath($path);
    }

    public function test_it_can_get_permission_by_path()
    {
        $path = 'isDeveloper';

        $results = $this->PermissionsRepository->getPermissionByPath($path);
        assertInternalType('array', $results);
        assertInternalType('array', $results['and']);
    }

    public function test_it_can_get_all_permissions_paginated(){
        $results = $this->PermissionsRepository->allPermissionsPaginated(2);
        assertInstanceOf('Illuminate\Pagination\LengthAwarePaginator', $results);
    }

    public function test_it_can_get_available_rules_list()
    {
        $results = $this->PermissionsRepository->availableRulesList();
        assertInternalType('array', $results);
        assertArrayHasKey('isLoggedIn', $results);
    }

    public function test_it_can_get_rule_param_map()
    {
        $rules = $this->PermissionsRepository->availableRulesList();
        $results = $this->PermissionsRepository->getRuleParamMap($rules);

        assertInternalType('array', $results);
        assertEquals(1, $results['hasEmail']);
    }
}