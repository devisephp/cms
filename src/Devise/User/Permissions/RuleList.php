<?php namespace Devise\User\Permissions;

use Auth;
use Exception;
use User;

class RuleList {
    public $closures;
    public $rules;
    protected $User;

    public function __construct(User $User)
    {
        $this->User = $User;

        // set $rules to array of all methods in this Class (RuleList)
        $this->rules = get_class_methods($this);
    }

    /**
     * Handle execution of the different types of methods
     *
     * @param  string  $method      Name of function/method
     * @param  array   $arguments   Any arguments required by method
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
        return Auth::check();
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
            $user = Auth::user();
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
            $user = Auth::user();
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
     * @param  string  $username     Specified username or email address
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
     * Check db field for specific value
     *
     * @param  string  $field
     * @param  string  $value
     * @return boolean
     */
    public function hasFieldValue($field, $value)
    {
        if($this->isLoggedIn()) {
            $user = Auth::user();
            if(isset($user->$field)) {
                return $user->$field == $value;
            }
        }
        return false;
    }

}
