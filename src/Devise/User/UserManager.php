<?php namespace Devise\User;

use User;
use Illuminate\Hashing\BcryptHasher as Hash;
use Devise\Common\Manager;

class UserManager extends Manager
{
	protected $User;

    public $messages = array(
        'email.required' => 'Email address required.',
        'email.email' => 'Email address invalid.',
        'email.unique' => 'Email address already in use.',
        'password.required' => 'Password required.',
        'password_confirmation.required' => 'Password confirmation required.',
        'password_confirmation.same:password' => 'Password confirmation does not match password.',
        'group_id.required' => 'Group is required.',
        'group_id.exists' => 'Group must be valid.',
        'email.exists' => 'Email address not found. Please try again.',
        'current_password.required' => 'Current password required.',
        'new_password.required' => 'New password required.',
        'new_password_confirmation.required' => 'New password confirm required.',
        'new_password_confirmation.same:password' => 'New password confirm must match new password.',
    );

	/**
	 * Construct a new user manager
	 *
	 * @param User $User
	 * @param Hash $Hash
	 */
	public function __construct(User $User, Hash $Hash)
	{
		$this->User = $User;
		$this->Hash = $Hash;
	}

	/**
	 * These are create rules for a user
	 *
	 * @return array
	 */
	public function createRules()
	{
		return array(
        	'email' => 'required|email|unique:users',
        	'password' => 'required|min:6',
        	'password_confirmation' => 'required|min:6|same:password',
        	'group_id' => 'required|exists:groups,id'
		);
	}

	/**
	 * Create a new user
	 *
	 * @param  array $input
	 * @return $this
	 */
	public function createUser($input)
	{
		if ($this->fails($input, $this->createRules(), "Could not create user")) return $this;

		$user = $this->User;
		$user->email = $input['email'];
		$user->password = $this->Hash->make($input['password']);
		$user->save();

		// sync the group for the user
		$user->groups()->sync([$input['group_id']]);

		return $this;
	}

	/**
	 * These are update rules for a user
	 *
	 * @param  integer $id
	 * @param  array   $input
	 * @return array
	 */
	public function updateRules($id, $input)
	{
		$updateRules = array(
        	'email' => "required|email|unique:users,email,{$id}",
        	'group_id' => 'exists:groups,id',
		);

		// if password is being updated then our rules
		// change accordingly
		$password = array_get($input, 'password', '');

		if ($password)
		{
			$updateRules['password'] = 'required|min:6';
			$updateRules['password_confirmation'] = 'required|min:6|same:password';
		}

		return $updateRules;
	}

	/**
	 * Update a new user
	 *
	 * @param  integer $id
	 * @param  array $input
	 * @return $this
	 */
	public function updateUser($id, $input)
	{
		// ensure validation passes
		if ($this->fails($input, $this->updateRules($id, $input), "Could not update user")) return $this;

		// update this user now that validation has passed
		$user = $this->User->findOrFail($id);
		$user->email = $input['email'];

		if(array_get($input, 'password', null)) {
			$user->password = $this->Hash->make($input['password']);
		}

		$user->save();

		$user->groups()->sync(array_get($input, 'group_id', []));

		return $this;
	}

	/**
	 * Delete a user
	 *
	 * @param  integer $id
	 * @return $this
	 */
	public function destroyUser($id)
	{
		$user = $this->User->findOrFail($id);

		$user->delete();

		return $this;
	}
}