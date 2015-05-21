<?php namespace Devise\Users;

use Devise\Users\Permissions\RuleList;
use Devise\Users\Permissions\RuleManager;
use Devise\Users\UsersRepository;
use Devise\Support\Framework;

/**
 * Helper allows specific methods to be easily accessible through
 * the DeviseUser facade.
 */
class UserHelper
{
    /**
     * RuleList keeps on-going list of built-in and added rules
     *
     * @var RuleList
     */
    protected $RuleList;

    /**
     * RuleManager manages rules
     *
     * @var RuleManager
     */
    protected $RuleManager;

    /**
     * UsersRepository fetches users and related data
     *
     * @var UsersRepository
     */
    protected $UsersRepository;

    /**
     * Framework components being used from Laravel's framework
     *
     * @var Devise\Support\Framework
     */
    protected $Framework;

    public function __construct(RuleManager $RuleManager, UsersRepository $UsersRepository, Framework $Framework)
    {
        $this->RuleManager = $RuleManager;
        $this->UsersRepository = $UsersRepository;
        $this->App = $Framework->Container;
        $this->RuleList = $this->App->make('rulelist');
    }

    /**
     * Magic method to used to catch function(s) not found in RuleManager
     *
     * @param  string $method
     * @param  array  $arguments
     * @return boolean
     */
    public function __call($method, $arguments)
    {
        return $this->checkRule($method, $arguments);
    }

    /**
     * Convenience function to get current user object
     *
     * @return DvsUser
     */
    public function currentUser()
    {
        return $this->UsersRepository->retrieveCurrentUser();
    }

    /**
     * Convenience function to get current user's id
     *
     * @return integer
     */
    public function currentUserId()
    {
        return $this->UsersRepository->retrieveCurrentUserId();
    }

    /**
     * Convenience function for handing a single condition name or an
     * array of multiple condition names.
     *
     * @param  string | array  $conditionNames
     * @param  boolean         $redirectOnFail
     * @return void
     */
    public function checkConditions($conditionNames, $redirectOnFail = false)
    {
        if(!is_array($conditionNames)) {
            return $this->RuleManager->runCondition($conditionNames, $redirectOnFail);
        }

        return $this->checkConditionsArray($conditionNames, $redirectOnFail);
    }

    /**
     * Checks for any user-defined rules/closures
     *
     * @param  string  $method
     * @param  array  $arguments
     * @return void
     */
    public function checkRule($method, $arguments = array())
    {
        return call_user_func_array(array($this->RuleList, $method), $arguments);
    }

    /**
     * Checks conditions by name and then evaulates results
     *
     * @param  array  $conditionNamesArr
     * @param  boolean  $redirectOnFail
     * @return void
     */
    private function checkConditionsArray($conditionNamesArr = array(), $redirectOnFail = false)
    {
        $resultsArr = array();
        foreach($conditionNamesArr as $conditionName) {
            $resultsArr[] = $this->RuleManager->runCondition($conditionName, $redirectOnFail, false);
        }
        return $this->RuleManager->evaluateResults(array_flatten($resultsArr), $redirectOnFail);
    }

}