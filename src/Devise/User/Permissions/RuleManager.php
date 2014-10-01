<?php namespace Devise\User\Permissions;

use App;
use Config;
use Exception;
use Devise\User\Permissions\RedirectHandler;

class RuleManager {
    protected $RedirectHandler;
    protected $RuleList;

    public function __construct(RedirectHandler $RedirectHandler)
    {
        $this->RedirectHandler = $RedirectHandler;
        $this->RuleList = App::make('rulelist');
    }

    /**
     * Get all rules
     *
     * @return Array
     */
    public function getRules()
    {
        return $this->RuleList->rules;
    }

    /**
     * Get all closures
     *
     * @return Array
     */
    public function getClosure($method)
    {
        if(isset($this->RuleList->closures[$method])) {
            return $this->RuleList->closures[$method];
        } else {
           throw new Exception('Unknown Function "'.$method.'" in RuleManager');
        }
    }

    /**
     * Add new element to rules array
     *
     * @param  string   $rule
     * @param  callback $closure
     * @return Void
     */
    public function addRule($rule, $closure = null)
    {
        if($this->ruleNameAvailable($rule)) {
            $this->RuleList->rules[] = $rule;
            $this->RuleList->closures[$rule] = $closure;
        } else {
            throw new Exception('Rule name "'.$rule.'" already in use.');
        }
    }

    /**
     * Retrieve conditions JSON from permission conditions config
     *
     * @param  string  $conditionName
     * @return Void
     */
    public function getCondition($conditionName)
    {
        $condition = json_encode(Config::get('devise::permission-conditions.'.$conditionName));
        if(!$condition) {
            throw new Exception($conditionName.' condition not found');
        }
        return $condition;
    }

    /**
     * Begins condition checking process by retrieving condition
     * by name/key and then executing its contents.
     *
     * @param string $conditionName
     * @param boolean $redirectOnFail
     * @param boolean $evaluateResults  If false, call to evaluateResults() is omitted
     * @return Void
     */
    public function runCondition($conditionName, $redirectOnFail, $evaluateResults = true)
    {
        $condition = $this->getCondition($conditionName);
        $results = $this->executeCondition($condition);

        return ($evaluateResults) ? $this->evaluateResults($results, $redirectOnFail) : $results;
    }

    /**
     * Executes conditions one at a time and returns result
     *
     * @param object  $conditionObject
     * @return boolean
     */
    public function executeCondition($conditionObject)
    {
        $conditions = json_decode($conditionObject);
        return $this->parseCondition($conditions);
    }

    /**
     * Determines if access allowed/denied by checking
     * results array for any occurences of a "false" value
     *
     * @param  object  $conditionObject
     * @param  boolean $redirectOnFail
     * @return boolean
     */
    public function evaluateResults($results, $redirectOnFail)
    {
        if(in_array(false, $results)) {
            if($redirectOnFail) {
                return $this->RedirectHandler->redirect(json_decode($conditionObject));
            }
            return false;
        }
        return true;
    }

    /**
     * Checks rules array to see if rule/function
     * name has already been used for rule
     *
     * @param  string  $rule   Name of the rule being checked
     * @return boolean
     */
    private function ruleNameAvailable($rule)
    {
        return (in_array($rule, $this->RuleList->rules)) ? false : true;
    }

    /**
     * Iterate thru conditions and determines if condition is true or false
     *
     * @return Void
     */
    private function parseCondition(&$conditions, $parentOperator = null)
    {
        $conditionResults = array();
        foreach($conditions as $functionOperator => $groupArguments) {
            if($functionOperator == 'and' || $functionOperator == 'or') {
                $groupResults = $this->parseCondition($groupArguments, $functionOperator);

                if($parentOperator == 'and') {
                    return array(!in_array(false, $groupResults));
                }

                return array(in_array(true, $groupResults));
            } else {
                $conditionResults[] = call_user_func_array(array($this->RuleList, $functionOperator), $groupArguments);
            }
        }
        return $conditionResults;
    }

}