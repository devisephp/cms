<?php namespace Devise\User\Helpers;

use App;
use Devise\User\Permissions\RuleList;
use Devise\User\Permissions\RuleManager;
use Devise\User\Repositories\UsersRepository;

class UserHelper {
    protected $RuleList;
    protected $RuleManager;
    protected $UsersRepository;

    public function __construct(RuleManager $RuleManager, UsersRepository $UsersRepository)
    {
        $this->RuleList = App::make('rulelist');
        $this->RuleManager = $RuleManager;
        $this->UsersRepository = $UsersRepository;
    }

    /**
     * Catch function(s) not found in RuleManager
     *
     * @param  string $method
     * @param  array  $arguments
     * @return boolean
     */
    public function __call($method, $arguments = array())
    {
        return $this->checkRule($method, $arguments);
    }

    /**
     * Convenience function to get current user object.
     *
     * @return User
     */
    public function currentUser()
    {
        return $this->UsersRepository->retrieveCurrentUser();
    }

    /**
     * Convenience function to get current user's id.
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
     * Checks for any user-defined rules/closures.
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
     * Handles checking an array of condition names.
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