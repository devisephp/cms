<?php namespace Devise\Users\Permissions;

use \Illuminate\Filesystem\Filesystem as Filesystem;
use Devise\Support\Config\FileManager as ConfigFileManager;

use Mockery as m;

class PermissionsManagerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->Framework = new \Devise\Support\Framework;

        $this->Filesystem = new Filesystem;

        $this->ConfigFileManager = m::mock(new ConfigFileManager($this->Filesystem, $this->Framework));
        $this->ConfigFileManager->shouldReceive('saveToFile')->andReturn(['some' => 'stuff']);

        $this->PermissionsManager = new PermissionsManager($this->ConfigFileManager, $this->Framework);
    }

    public function test_it_cannot_store_permission()
    {
        $input = $this->buildInput([
            'permission_name' => 'blah blah blah'
            ]);

        $result = $this->PermissionsManager->storePermission($input);

        assertInternalType('bool', $result);
        assertEquals(false, $result);
    }

    public function test_it_can_store_permission()
    {
        $input = $this->buildInput();

        $result = $this->PermissionsManager->storePermission($input);

        assertInternalType('array', $result);
    }

    public function test_it_can_update_permission()
    {
        $input = $this->buildInput(['permission_name_edit' => 'newPermission']);

        $result = $this->PermissionsManager->updatePermission($input);

        assertInternalType('array', $result);
    }

    public function test_it_cannot_destroy_permission()
    {
       $result = $this->PermissionsManager->destroyPermission('doesNotExist');

       assertFalse($result);
    }

    public function test_it_can_destroy_permission()
    {

        $result = $this->PermissionsManager->destroyPermission('isDeveloper');

        assertInternalType('array', $result);
    }

    private function buildInput($newInput = []) {

        $input = [
            'permission_name'  => 'newPermission',
            'redirect'         => 'some-route',
            'redirect_type'    => 'route',
            'redirect_message' => 'These aren\'t the droids you are looking for',
            'condition'        => 'and',
            'newPermission'    => [
                "and"          => [
                    'isLoggedIn'   => ['isLoggedIn'],
                    'isInGroup'   => ['isInGroup', 'Super Group']
                ]
            ]
        ];

        return array_merge($input, $newInput);
    }
}