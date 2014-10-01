<?php namespace Devise\User\Repositories;

use Auth;
use Str;
use DvsUser as User;

class UsersRepository {
    protected $User;
    public $message;
    public $errors;

    public function __construct(User $User)
    {
        $this->User = $User;
    }

    /**
     * Retrieve currently logged-in user object
     *
     * @return User | null
    */
    public function retrieveCurrentUser()
    {
        return $this->findById(Auth::id());
    }

    /**
     * Retrieve current user's id
     *
     * @return Integer | null
    */
    public function retrieveCurrentUserId()
    {
        return Auth::id();
    }

    /**
     * Search for users
     *
     * @param  array   $filters
     * @param  integer $perPage
     * @return Eloquent\Collection
     */
    public function retrievePaginated()
    {
        return $this->User->paginate();
    }

    /**
     * Find user by id
     *
     * @param  int  $id
     * @return DeviseUser
    */
    public function findById($id)
    {
        return $this->User->with('groups')->findOrFail($id);
    }

    /**
     * Find user by email address
     *
     * @param  string  $email
     * @return DeviseUser
    */
    public function findByEmail($email)
    {
        return $this->User->with('groups')->whereEmail($email)->first();
    }

    /**
     * Paginated list of users
     *
     * @return Eloquent\Collection
     */
    public function users()
    {
        return $this->User->paginate();
    }

    /**
     * Activate user
     *
     * @param  object  $user
     * @return Boolean
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
     * @param  object  $user
     * @param  integer  $length
     * @return String
     */
    public function generateActivateCode($user, $length = 42)
    {
        $user->activate_code = Str::random($length);
        return $user->save();
    }
}
