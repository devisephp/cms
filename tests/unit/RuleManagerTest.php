<?php

use Devise\User\Permissions\RuleManager;
use Mockery as m;

class RuleManagerTest extends Orchestra\Testbench\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * Test __call() method throws an exception for an unknown function in the RuleManager
     */
    public function testCallMethodFailsWhenUnknownFunctionIsCalled()
    {
        $rulelist = m::mock('Devise\User\Permissions\RuleManager');

        $mockRedirectHandler = m::mock('Devise\User\Permissions\RedirectHandler');
        $RuleManager = new RuleManager($mockRedirectHandler);
    }
}
