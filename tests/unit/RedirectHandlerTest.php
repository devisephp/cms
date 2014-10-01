<?php

use Devise\User\Permissions\RedirectHandler;
use Illuminate\Routing\Redirector as Redirect;
use Mockery as m;

class RedirectHandlerTest extends Orchestra\Testbench\TestCase
{
    public function tearDown()
    {
        m::close();
    }

    /**
     * Test login method is successful with valid input data
     */
    public function testRedirectIsSuccessfulForRedirectTypeRoute()
    {
        $conditionArray = array(
            'redirect' => 'DeviseUserController@login',
            'redirect_type' => 'action',
            'redirect_message' => 'Uh-oh!! You don\'t have permission to view this.'
        );

        // Convert conditionsArray into a valid object
        $conditionObject = json_decode(json_encode($conditionArray), FALSE);

        $mockRedirect = m::mock('Illuminate\Routing\Redirector');
        $mockRedirect->shouldReceive($conditionObject->redirect_type)
            ->andReturnSelf()
            ->shouldReceive('with')
            ->andReturn($conditionObject->redirect_message);

        $redirectHandler = new RedirectHandler($mockRedirect);
        $result = $redirectHandler->redirect($conditionObject);

        // Check for fail/permission denied message and type equals string
        $this->assertEquals($result, 'Uh-oh!! You don\'t have permission to view this.');
        $this->assertInternalType('string', $result);
    }

}
