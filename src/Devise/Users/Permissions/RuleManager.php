<?php namespace Devise\Users\Permissions;

use Devise\Support\Framework;

/**
 * Class RuleManager manages retrieval, creation/addition, execution
 * and evaluation of native and user-defined rules.
 */
class RuleManager
{
    /**
     * RedirectHandler redirects user-defined permission conditions
     *
     * @var RedirectHandler
     */
    protected $RedirectHandler;

    /**
     * RuleList fetches list of rules
     *
     * @var RuleList
     */
    protected $RuleList;

    /**
     * Framework components being used from Laravel's framework
     *
     * @var \Devise\Support\Framework
     */
    protected $Framework;

    /**
     * Construct a new rule manager
     *
     * @param RedirectHandler $RedirectHandler
     * @param Framework $Framework
     */
    public function __construct(RedirectHandler $RedirectHandler, Framework $Framework)
    {
        $this->RedirectHandler = $RedirectHandler;
        $this->App = $Framework->Container;
        $this->RuleList = $this->App->make('rulelist');
        $this->Config = $Framework->Config;
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
     * Get all rules
     *
     * @return Array
     */
    public function getNumberOfRequiredParametersForRule($ruleName)
    {

        if(in_array($ruleName, get_class_methods($this->RuleList))) {
            $fct = new \ReflectionMethod($this->RuleList, $ruleName);
            return $fct->getNumberOfRequiredParameters();
        } else {
            $fct = new \ReflectionFunction($this->RuleList->closures[ $ruleName ]);
            return $fct->getNumberOfRequiredParameters();
        }

        return 0;
    }

    /**
     * Get all closures
     *
     * @param  string $method
     * @throws \Devise\Support\DeviseException
     * @return Array
     */
    public function getClosure($method)
    {
        if(isset($this->RuleList->closures[$method])) {
            return $this->RuleList->closures[$method];
        } else {
           throw new \Devise\Support\DeviseException('Unknown Function "'.$method.'" in RuleManager');
        }
    }

    /**
     * Add new element to rules array
     *
     * @param  string $rule
     * @param  callback $closure
     * @throws \Devise\Support\DeviseException
     * @return Void
     */
    public function addRule($rule, $closure = null)
    {
        if($this->ruleNameAvailable($rule)) {
            $this->RuleList->rules[] = $rule;
            $this->RuleList->closures[$rule] = $closure;
        } else {
            throw new \Devise\Support\DeviseException('Rule name "'.$rule.'" already in use.');
        }
    }

    /**
     * Retrieve conditions JSON from permission conditions config
     *
     * @param  string $conditionName
     * @throws \Devise\Support\DeviseException
     * @return Void
     */
    public function getCondition($conditionName)
    {
        $condition = json_encode($this->Config->get('devise::permissions.'.$conditionName));
        if(!$condition) {
            throw new \Devise\Support\DeviseException($conditionName.' condition not found');
        }
        return $condition;
    }

    /**
     * Begins condition checking process by retrieving condition
     * by name/key and then executing its contents.
     *
     * @param string $conditionName
     * @param boolean $redirectOnFail
     * @param boolean $evaluateResults   If false, evaluateResults() omitted
     * @return Void
     */
    public function runCondition($conditionName, $redirectOnFail, $evaluateResults = true)
    {
        $condition = $this->getCondition($conditionName);
        $results = $this->executeCondition($condition);

        return ($evaluateResults) ? $this->evaluateResults($results, $redirectOnFail, $condition) : $results;
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
    public function evaluateResults($results, $redirectOnFail, $conditionObject)
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
            if(!in_array($functionOperator, array('redirect','redirect_message','redirect_type'))){
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
        }
        return $conditionResults;
    }

}