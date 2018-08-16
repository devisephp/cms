<?php namespace Devise\Users;

use Illuminate\Support\Str;
use Devise\Support\Framework;

/**
 * Class UserManager manages the creating of new users,
 * updating existing users and removing users.
 */
class UserManager
{
    /**
     * DvsUser model to fetch database table
     *
     * @var DvsUser
     */
    protected $DvsUser;

    /**
     * Framework components being used from Laravel's framework
     *
     * @var Framework
     */
    protected $Framework;

    /**
     * Errors are kept in an array and can be
     * used later if validation fails and we want to
     * know why
     *
     * @var array
     */
    public $errors = [];

    /**
     * Messages which we can store why validation failed
     *
     * @var string
     */
    public $messages = array(
        'email.required' => 'Email address required.',
        'email.email' => 'Email address invalid.',
        'email.unique' => 'Email address already in use.',
        'username.required' => 'Username required.',
        'username.unique' => 'Username already in use.',
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
     * @param \DvsUser $DvsUser
	 * @param Framework $Framework
	 */
	public function __construct(\DvsUser $DvsUser, Framework $Framework)
	{
		$this->DvsUser = $DvsUser;
        $this->Hash = $Framework->Hash;
		$this->Validator = $Framework->Validator;
	}

	/**
	 * Create rules for a new user
	 *
	 * @return array
	 */
	public function createRules()
	{
		return array(
        	'email' => 'required|email|unique:users',
			'username' => 'required|unique:users',
        	'password' => 'required|min:6',
        	'password_confirmation' => 'required|min:6|same:password',
        	'group_id' => 'required|exists:groups,id'
		);
	}

	/**
	 * Create a new user
	 *
	 * @param  array $input
	 * @return DvsUser
	 */
	public function createUser($input)
	{
        $validator = $this->Validator->make($input, $this->createRules(), $this->messages);

        if ($validator->passes())
        {
    		$user = $this->DvsUser;
    		$user->activated = array_get($input, 'activated', false);
            $user->name = array_get($input, 'name', null);
    		$user->email = array_get($input, 'email');
    		$user->username = array_get($input, 'username', null);
    		$user->password = $this->Hash->make(array_get($input, 'password'));
    		$user->save();

    		$user->groups()->sync([array_get($input, 'group_id', [])]);

    		return $user;
        }

        $this->errors = $validator->errors()->all();
        $this->message = "There were validation errors.";
        return false;
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
			'username' => "required|unique:users,username,{$id}",
        	'group_id' => 'required|exists:groups,id',
		);

		$password = array_get($input, 'password', null);

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
	 * @return DvsUser
	 */
	public function updateUser($id, $input)
	{
        $validator = $this->Validator->make($input, $this->updateRules($id, $input), $this->messages);

        if ($validator->passes())
        {
    		$user = $this->DvsUser->findOrFail($id);
    		$user->activated = array_get($input, 'activated', false);
            $user->name = array_get($input, 'name', null);
    		$user->email = array_get($input, 'email');
    		$user->username = array_get($input, 'username', null);

    		if(array_get($input, 'password', null)) {
    			$user->password = $this->Hash->make(array_get($input, 'password'));
    		}

    		$user->save();

    		$user->groups()->sync(array_get($input, 'group_id', []));

            return $user;
        }

        $this->errors = $validator->errors()->all();
        $this->message = "There were validation errors.";
        return false;
	}

	/**
	 * Delete a user
	 *
	 * @param  integer $id
	 * @return boolean
	 */
	public function destroyUser($id)
	{
		$user = $this->DvsUser->findOrFail($id);
        return $user->delete();
	}

    /**
     * Register new user
     *
     * @param  array  $input
     * @return Boolean
    */
    public function registerUser($input)
    {
        // if no group_id in input, default to "Adminstrator"
        $input['group_id'] = array_get($input, 'group_id', 2);

        if($user = $this->createUser($input))
        {
            $this->generateActivateCode($user);

            $this->message = 'User successfully registered. An email has been sent with an activation link.';
            return $user;
        }

        return false;
    }


    /**
     * Activate instance of DvsUser
     *
     * @param  DvsUser  $user
     * @return boolean
    */
    public function activate($user)
    {
        $user->activated = true;
        $user->activate_code = null;
        return $user->save();
    }

    /**
     * Generate a random "activate_code" string
     *
     * @param  DvsUser  $user
     * @param  integer  $length
     * @return void
     */
    public function generateActivateCode($user, $length = 42)
    {
        $user->activate_code = Str::random($length);
        $user->save();
    }

    /**
     * Removes users which have been awaiting activation (after
     * registering). Currently, default is 30 days outstanding
     *
     * @return Boolean
    */
    public function removeUnactivatedUsers($daysOutstanding = 30)
    {
        $outstandingDate = date("Y-m-d H:i:s", strtotime('now -'.$daysOutstanding.' days'));

        if($this->DvsUser->where('activated','=',false)->where('created_at','<=',$outstandingDate)->forceDelete()) {
            return true;
        }

        return false;
    }

}