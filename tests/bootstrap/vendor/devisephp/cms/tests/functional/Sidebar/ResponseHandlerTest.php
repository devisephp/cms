<?php namespace Devise\Sidebar;

use Mockery as m;

class ResponseHandlerTest extends \DeviseTestCase
{
    public function test_it_can_request_sidebar()
    {
        $Manager = m::mock('Devise\Sidebar\SidebarManager');
        $Manager->shouldReceive('fetchPartialView')->andReturn('some html here');
        $ResponseHandler = new ResponseHandler($Manager);
        $ResponseHandler->requestSidebarPartial(['data' => 'mocked']);
    }

    public function test_it_can_request_element()
    {
        $Manager = m::mock('Devise\Sidebar\SidebarManager');
        $Manager->shouldReceive('fetchElementView')->andReturn('some html here');
        $ResponseHandler = new ResponseHandler($Manager);
        $ResponseHandler->requestElementPartial(['data' => 'mocked']);
    }

    public function test_it_can_request_grid()
    {
        $Manager = m::mock('Devise\Sidebar\SidebarManager');
        $Manager->shouldReceive('fetchElementGridView')->andReturn('some html here');
        $ResponseHandler = new ResponseHandler($Manager);
        $ResponseHandler->requestElementGridPartial(['data' => 'mocked']);
    }

    public function test_it_can_request_model_update()
    {
        $Manager = m::mock('Devise\Sidebar\SidebarManager');
        $Manager->shouldReceive('updateModel')->andReturn('some html here');
        $ResponseHandler = new ResponseHandler($Manager);
        $ResponseHandler->requestUpdateModel(['data' => 'mocked']);
    }
}