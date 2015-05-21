<?php namespace Devise\Menus;

use Mockery as m;

class MenusResponseHandlerTest extends \DeviseTestCase
{
    public function setUp()
    {
        $this->Redirect = m::mock('Illuminate\Routing\Redirector');
        $this->Manager = m::mock('Devise\Menus\MenusManager');
        $this->MenusResponseHandler = new MenusResponseHandler($this->Redirect, $this->Manager);
    }
    public function test_it_requests_store()
    {
        $menu = new \DvsMenu;
        $menu->id = 1;
        $this->Manager->shouldReceive('createMenu')->times(1)->with([])->andReturn($menu);
        $this->Redirect->shouldReceive('route')->with('dvs-menus-edit', 1);
        $this->MenusResponseHandler->requestStore([]);
    }

    public function test_it_requests_update()
    {
        $this->Manager->shouldReceive('updateMenu')->times(1)->with(1, [])->andReturn(true);
        $this->Redirect->shouldReceive('route')->with('dvs-menus');
        $this->MenusResponseHandler->requestUpdate(1, []);
    }
}