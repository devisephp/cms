<?php namespace Devise\Users;

use Mockery as m;

class UserManagerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->Framework = m::mock('Devise\Support\Framework');
        $this->Framework->Validator = m::mock('Illuminate\Validation\Factory');
        $this->UserManager = new UserManager(new \DvsUser, $this->Framework);
    }

    public function test_it_has_create_rules()
    {
        assertInternalType('array', $this->UserManager->createRules());
    }

    public function test_it_cannot_create_user()
    {
        $this->Framework->Validator->shouldReceive('make')->once()->andReturnSelf();
        $this->Framework->Validator->shouldReceive('fails')->once()->andReturnSelf();
        $this->UserManager->createUser(['foo' => 'input data']);
    }

    public function test_it_can_create_user()
    {
        $validInput = [
            'email' => 'deviseadmin2@lbm.co',
            'name' => 'mister devise',
            'group_id' => '1',
            'password' => 'secret'
        ];

        $this->Framework->Validator->shouldReceive('make')->once()->andReturnSelf();
        $this->Framework->Validator->shouldReceive('fails')->once()->andReturn(null);
        $this->UserManager->createUser($validInput);
    }

    public function test_it_has_update_rules()
    {
        assertInternalType('array', $this->UserManager->updateRules(1, []));
    }

    public function test_it_cannot_update_user()
    {
        $this->Framework->Validator->shouldReceive('make')->once()->andReturnSelf();
        $this->Framework->Validator->shouldReceive('fails')->once()->andReturnSelf();
        $this->UserManager->updateUser(1, ['foo' => 'input data']);
    }

    public function test_it_can_update_user()
    {
        $validInput = [
            'email' => 'deviseadmin2@lbm.co',
            'name' => 'mister devise',
            'group_id' => '1',
            'password' => 'secret'
        ];

        $this->Framework->Validator->shouldReceive('make')->once()->andReturnSelf();
        $this->Framework->Validator->shouldReceive('fails')->once()->andReturn(null);
        $this->UserManager->updateUser(1, $validInput);
    }

    public function test_it_cannot_destroy_user()
    {
        $output = $this->UserManager->destroyUser(1);
        assertInternalType('boolean', $output);
    }

}