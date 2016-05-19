<?php namespace Devise\Users\Permissions;

use Exception;
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
    public function __construct(\DvsUser $User, Framework $Framework)
    {
        $this->rules = array_diff(get_class_methods($this), array('__call','__construct'));
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
            // check if closer exists allowing methods to be overwritten
            if(isset($this->closures[$method])) {
                return call_user_func_array($this->closures[$method], $arguments);
            } else if(in_array($method, get_class_methods($this))) {
                // check if function is a class method, if it is then execute it
                return call_user_func_array(array($this, $method), $arguments);
            } else {
                throw new Exception('Unknown Function "'.$method.'" in RuleList');
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
    protected function isLoggedIn()
    {
        return $this->Auth->check();
    }

    /**
     * Is user not logged in system
     *
     * @return boolean
     */
    protected function isNotLoggedIn()
    {
        return !$this->Auth->check();
    }

    /**
     * Checks if user is in a group
     *
     *  you can pass multiple groups in here
     *
     * isInGroup('group1', 'group2')
     * means the user is in either 'group1' or 'group2'
     *
     * @param  string  $groupname
     * @return boolean
     */
    protected function isInGroup($groupname)
    {
        if (!$this->isLoggedIn()) return false;

        $groups = [];

        $userGroups = [];

        $groupnames = func_get_args();

        $user = $this->User->find($this->Auth->user()->id);

        foreach ($groupnames as $groupname) $groups[] = strtolower($groupname);

        foreach($user->groups as $group) $userGroups[] = strtolower($group->name);

        foreach($groups as $group)
        {
            if (in_array($group, $userGroups)) return true;
        }

        return false;
    }

    /**
     * Check user is not in a group
     *
     * @param  string  $groupname
     * @return boolean
     */
    protected function isNotInGroup($groupname)
    {
        if (!$this->isLoggedIn()) return false;
        
        return ! call_user_func_array([$this, 'isInGroup'], func_get_args());
    }

    /**
     * Check to see if user is in all groups
     *
     * isInGroup('group1', 'group2')
     * means user is in both 'group1' AND 'group1'
     *
     * @param  [type]  $groupname
     * @return boolean
     */
    protected function isInGroups($groupname)
    {
        if (!$this->isLoggedIn()) return false;

        $groups = [];

        $userGroups = [];

        $groupnames = func_get_args();

        $user = $this->User->find($this->Auth->user()->id);

        foreach ($groupnames as $groupname) $groups[] = strtolower($groupname);

        foreach($user->groups as $group) $userGroups[] = strtolower($group->name);

        foreach($groups as $group)
        {
            if (!in_array($group, $userGroups)) return false;
        }

        return true;
    }

    /**
     * Check to see if user is not in all the groups
     *
     * @param  [type]  $groupname
     * @return boolean
     */
    protected function isNotInGroups($groupname)
    {
        if (!$this->isLoggedIn()) return false;
        
        return ! call_user_func_array([$this, 'isInGroups'], func_get_args());
    }

    /**
     * Check if name field equals specified name value
     *
     * @param  string  $name
     * @return boolean
     */
    protected function hasName($name)
    {
        return $this->hasFieldValue('name', $name);
    }

    /**
     * Check if email field equals specified email
     *
     * @param  string  $email
     * @return boolean
     */
    protected function hasEmail($email)
    {
        return $this->hasFieldValue('email', $email);
    }

    /**
     * Check if username equals specified username value
     *
     * @param  string  $username
     * @return boolean
     */
    protected function hasUserName($username)
    {
        return $this->hasFieldValue('username', $username);
    }

    /**
     * Check if database field is equal to the specified value
     *
     * @param  string  $field
     * @param  string  $value
     * @return boolean
     */
    protected function hasFieldValue($field, $value)
    {
        if($this->isLoggedIn()) {
            $user = $this->User->find($this->Auth->user()->id);
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
    protected function showDeviseSpan($key, $collection)
    {
        return $this->isLoggedIn();
    }
}
