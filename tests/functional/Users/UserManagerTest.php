<?php namespace Devise\Users;

use Mockery as m;

class UserManagerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->Framework = new \Devise\Support\Framework;
        $this->DvsUser = new \DvsUser;
        $this->UserManager = new UserManager($this->DvsUser, $this->Framework);
    }

    public function test_it_has_create_rules()
    {
        assertInternalType('array', $this->UserManager->createRules());
    }

    public function test_it_cannot_create_invalid_user()
    {
        assertFalse($this->UserManager->createUser(['foo' => 'input data']));
    }

    public function test_it_can_create_user()
    {
        $validInput = [
            'email' => 'deviseadmin2@lbm.co',
            'name' => 'mister devise',
            'group_id' => ['1'],
            'password' => 'secret'
        ];

        $this->UserManager->createUser($validInput);
    }

    public function test_it_has_update_rules()
    {
        assertInternalType('array', $this->UserManager->updateRules(1, []));
    }

    public function test_it_cannot_update_user()
    {
        assertFalse($this->UserManager->updateUser(1, ['foo' => 'input data']));
    }

    public function test_it_can_update_user()
    {
        $validInput = [
            'email' => 'deviseadmin2@lbm.co',
            'name' => 'mister devise',
            'group_id' => ['1'],
            'password' => 'secret'
        ];

        $this->UserManager->updateUser(1, $validInput);
    }

    public function test_it_cannot_destroy_user()
    {
        $output = $this->UserManager->destroyUser(1);
        assertInternalType('boolean', $output);
    }

    public function test_it_can_register_user()
    {
        $groupId = 2;

        $input = [
            '_token' => 'someFooToken',
            'name' => 'Foo Name',
            'email' => 'foo@email.com',
            'password' => 'foo_pass',
            'password_confirmation' => 'foo_pass'
        ];

        $output = $this->UserManager->registerUser( $input, $groupId );
        assertInstanceOf('DvsUser', $output);
    }

    public function test_it_cannot_register_user()
    {
        assertFalse( $this->UserManager->registerUser(['foo' => 'input']) );
    }

    public function test_it_can_activate_user()
    {
        $user = $this->retrieveValidUserInstance();
        assertTrue( $this->UserManager->activate($user) );
    }

    public function test_it_can_generate_activate_code()
    {
        $user = $this->retrieveValidUserInstance();
        assertNull( $this->UserManager->generateActivateCode($user) );
    }

    public function test_it_can_remove_unactivated_users()
    {
        assertTrue( $this->UserManager->removeUnactivatedUsers() );
    }

    public function test_it_cannot_remove_unactivated_users()
    {
        // by passing thru daysOutstanding value of 90, no users
        // should be found with a created_at date greater
        assertFalse( $this->UserManager->removeUnactivatedUsers(90) );
    }

    /**
     * Returns a valid instance of DvsUser.
     *
     * @return DvsUser
     */
    private function retrieveValidUserInstance()
    {
        $UsersRepository = new \Devise\Users\UsersRepository(
            new \DvsUser,
            $this->Framework
        );

        return $UsersRepository->findById(1);
    }
}