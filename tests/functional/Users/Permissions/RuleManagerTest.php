<?php namespace Devise\Users\Permissions;

use Devise\Users\Permissions\RedirectHandler;
use Mockery as m;

class RuleManagerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->Framework = new \Devise\Support\Framework;
        $this->RedirectHandler = new RedirectHandler($this->Framework);
        $this->RuleManager = new RuleManager($this->RedirectHandler, $this->Framework);
    }

    public function test_it_can_get_rules()
    {
        assertInternalType('array', $this->RuleManager->getRules());
    }

    public function test_it_has_default_rules()
    {
        assertEquals($this->RuleManager->getRules()[2], 'isLoggedIn');
    }

    public function test_it_can_get_number_of_required_parameters_for_rule()
    {
        assertEquals($this->RuleManager->getNumberOfRequiredParametersForRule('isLoggedIn'), 0);
        assertEquals($this->RuleManager->getNumberOfRequiredParametersForRule('hasUserName'), 1);
    }

    public function test_it_can_get_closure()
    {
        $this->RuleManager->addRule('whatever', function(){
            return true;
        });

        assertInstanceOf('Closure', $this->RuleManager->getClosure('whatever'));
    }

    public function test_it_cannot_get_closure()
    {
        $method = 'isLoggedIn';

        $this->setExpectedException('\Devise\Support\DeviseException', 'Unknown Function "'.$method.'" in RuleManager');
        $this->RuleManager->getClosure($method);
    }

    public function test_it_can_add_rules()
    {
        $this->RuleManager->addRule('whatever2', function(){
            return true;
        });

        assertInstanceOf('Closure', $this->RuleManager->getClosure('whatever2'));
    }

    public function test_it_can_overwrite_existing_rules()
    {
        $this->RuleManager->overwriteRule('showDeviseSpan', function(){
            return 'yes';
        });

        assertEquals('yes', $this->RuleManager->getClosure('showDeviseSpan')->__invoke());
    }

    public function test_it_cant_overwrite_nonexisting_rules()
    {
        $this->setExpectedException('Devise\Support\DeviseException');
        $this->RuleManager->overwriteRule('doesnotexits', function(){
            return true;
        });
    }

    public function test_it_can_get_conditions()
    {
        assertEquals('{"isInGroup":["Developer"]}', $this->RuleManager->getCondition('isDeveloper'));
    }

    public function test_it_cannot_get_conditions()
    {
        $conditionName = 'badConditionName';

        $this->setExpectedException('\Devise\Support\DeviseException', $conditionName.' condition not found');
        $this->RuleManager->getCondition($conditionName);
    }

    public function test_it_can_run_condition_without_type_goes_back()
    {
        $conditionName = 'isDeveloper';
        assertInstanceOf('Illuminate\Http\RedirectResponse', $this->RuleManager->runCondition($conditionName, true));
    }

    public function test_it_can_run_condition()
    {
        $conditionName = 'ifNotLoggedInGoToLogin';
        $RedirectHandlerMock = m::mock('Devise\Users\Permissions\RedirectHandler');
        $RedirectHandlerMock->shouldReceive('redirect')->once()->andReturn(true);

        $RuleManagerMock = m::mock(new RuleManager($RedirectHandlerMock, $this->Framework));

        assertEquals(true, $RuleManagerMock->runCondition($conditionName, true));
    }

    public function test_it_can_execute_condition()
    {
        $conditionName = 'isDeveloper';
        $conditionObject = $this->RuleManager->getCondition($conditionName);
        assertInternalType('array', $this->RuleManager->executeCondition($conditionObject));
    }

    public function test_it_can_evaluate_results()
    {
        $conditionName = 'isDeveloper';
        $conditionObject = $this->RuleManager->getCondition($conditionName);
        $results = $this->RuleManager->executeCondition($conditionObject);
        assertInternalType('boolean', $this->RuleManager->evaluateResults($results, false, $conditionObject));
        assertEquals(false, $this->RuleManager->evaluateResults($results, false, $conditionObject));
    }
}