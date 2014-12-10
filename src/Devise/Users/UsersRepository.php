<?php namespace Devise\Users;

use Devise\Support\Framework;

/**
 * Class UsersRepository is used to search and retrieve DvsUser models
 * and things in context of a Devise User.
 *
 * @package Devise\Users
 */
class UsersRepository
{
    /**
     * DvsUser model to fetch database records
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
     * Errors are kept in an array and can be used later
     * if validation fails and we want to know why
     *
     * @var array
     */
    public $errors;

    /**
     * This is a message that we can store why validation failed
     *
     * @var string
     */
    public $message;

    /**
     * Construct a new users repository
     *
     * @param \DvsUser $DvsUser
     * @param Framework $Framework
     */
    public function __construct(\DvsUser $DvsUser, Framework $Framework)
    {
        $this->DvsUser = $DvsUser;
        $this->Auth = $Framework->Auth;
    }

    /**
     * Retrieve currently logged-in user object
     *
     * @return DvsUser | null
    */
    public function retrieveCurrentUser()
    {
        return $this->findById($this->Auth->id());
    }

    /**
     * Retrieve current user id
     *
     * @return Integer | null
    */
    public function retrieveCurrentUserId()
    {
        return $this->Auth->id();
    }

    /**
     * Find user by id
     *
     * @param  int  $id
     * @return DvsUser
    */
    public function findById($id)
    {
        return $this->DvsUser->with('groups')->findOrFail($id);
    }

    /**
     * Paginated list of users
     *
     * @return Eloquent\Collection
     */
    public function users()
    {
        return $this->DvsUser->paginate();
    }

    /**
     * Find user by email address
     *
     * @param  string  $email
     * @return DvsUser
    */
    public function findByEmail($email)
    {
        return $this->DvsUser->with('groups')->whereEmail($email)->first();
    }

}
