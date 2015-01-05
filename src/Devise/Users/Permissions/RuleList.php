<?php namespace Devise\Users\Permissions;

use Exception;
use User;
use Devise\Support\Framework;

/**
 * Class RuleList maintains list of built-in and user defined functions (in
 * permissions-conditions config) which can be checked using DeviseUser Facade.
 */
class RuleList
{
    /**
     * Is this user logged in? Cache the value on this object
     * for performance reasons
     *
     * @var boolean
     */
    protected $isLoggedIn;

    /**
     * User model to fetch database table "users"
     *
     * @var User
     */
    protected $User;

    /**
     * Framework components being used from Laravel's framework
     *
     * @var Devise\Support\Framework
     */
    protected $Framework;

    /**
     * Closures are kept in an array and can be used to execute
     * user-defined condition(s) permissions/closures by key
     *
     * @var array
     */
    public $closures;

    /**
     * Rules are a list of built-in methods in this class which are kept
     * in an array; They are used to find and execute methods by name
     *
     * @var array
     */
    public $rules;

     /**
     * Construct a new RuleList
     *
     * @param \User $User
     * @param Framework $Framework
     */
    public function __construct(\User $User, Framework $Framework)
    {
        $this->rules = get_class_methods($this);
        $this->User = $User;
        $this->Auth = $Framework->Auth;
    }

    /**
     * Handle execution of the different types of methods
     *
     * @param  string $method Name of function/method
     * @param  array $arguments Any arguments required by method
     * @throws Exception
     * @return Void | Exception
     */
    public function __call($method, $arguments = array())
    {
        if(in_array($method, $this->rules)) {
            // check if function is a class method, if it is then execute it
            if(in_array($method, get_class_methods($this))) {
                return call_user_func_array(array($this, $method), $arguments);
            } else {
                // run closure since the "method" is not a class method
                $rule = function($m, $args) {
                    if(isset($this->closures[$m])) {
                        return $this->closures[$m]($args);
                    } else {
                       throw new Exception('Unknown Function "'.$m.'" in RuleList');
                    }
                };
                return call_user_func_array($rule, array($method, $arguments));
            }
        } else {
            throw new Exception('Unknown Function "'.$method.'" in RuleList');
        }
    }

    /**
     * Is user logged in system
     *
     * @return boolean
     */
    public function isLoggedIn()
    {
        return $this->Auth->check();
    }

    /**
     * Is user not logged in system
     *
     * @return boolean
     */
    public function isNotLoggedIn()
    {
        return $this->Auth->check();
    }

    /**
     * Checks if user is in a group
     *
     * @param  string  $groupname
     * @return boolean
     */
    public function isInGroup($groupname)
    {
        if($this->isLoggedIn()) {
            $user = $this->Auth->user();
            foreach($user->groups as $group) {
                if(strtolower($group->name) === strtolower($groupname)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Check user is not in a group
     *
     * @param  string  $groupname
     * @return boolean
     */
    public function isNotInGroup($groupname)
    {
        if($this->isLoggedIn()) {
            $user = $this->Auth->user();
            foreach($user->groups as $group) {
                if(strtolower($group->name) == strtolower($groupname)) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Determine if a username or email is used for application login.
     * Then checks if username/email equals specified value
     *
     * @param  string  $username  Handles username or email search
     * @return boolean
     */
    public function hasUserName($username)
    {
        if($this->hasFieldValue('username', $username)) {
            return true;
        }
        return $this->hasFieldValue('email', $username);
    }

    /**
     * Check if email field equals specified email
     *
     * @param  string  $email
     * @return boolean
     */
    public function hasEmail($email)
    {
        return $this->hasFieldValue('email', $email);
    }

    /**
     * Check if database field is equal to the specified value
     *
     * @param  string  $field
     * @param  string  $value
     * @return boolean
     */
    public function hasFieldValue($field, $value)
    {
        if($this->isLoggedIn()) {
            $user = $this->Auth->user();
            if(isset($user->$field)) {
                return $user->$field == $value;
            }
        }
        return false;
    }

    /**
     * Determines if we should show the devise span
     *
     * @param  [type] $key
     * @return [type]
     */
    public function showDeviseSpan($key, $collection)
    {
        return $this->isLoggedIn();
    }
}
