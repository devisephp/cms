<?php namespace Devise\Users\Permissions;

use Mockery as m;

class RedirectHandlerTest extends \DeviseTestCase
{
    public function setUp()
    {
        $this->Framework = m::mock('Devise\Support\Framework');
        $this->Framework->Redirect = m::mock('Illuminate\Routing\Redirector');
        $this->RedirectHandler = new RedirectHandler($this->Framework);
    }

    public function test_it_can_redirect_to_route()
    {
        $obj = new \stdClass;
        $obj->redirect = 'something';
        $obj->redirect_type = 'route';
        $this->Framework->Redirect->shouldReceive('route')->times(1)->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('with')->times(1)->andReturn('response');
        $this->RedirectHandler->redirect($obj);
    }

    public function test_it_can_redirect_to_url()
    {
        $obj = new \stdClass;
        $obj->redirect = 'something';
        $obj->redirect_type = 'to';
        $this->Framework->Redirect->shouldReceive('to')->times(1)->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('with')->times(1)->andReturn('response');
        $this->RedirectHandler->redirect($obj);
    }

    public function test_it_can_redirect_to_action()
    {
        $obj = new \stdClass;
        $obj->redirect = 'something';
        $obj->redirect_type = 'action';
        $this->Framework->Redirect->shouldReceive('action')->times(1)->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('with')->times(1)->andReturn('response');
        $this->RedirectHandler->redirect($obj);
    }

    public function test_it_can_redirect_back()
    {
        $obj = new \stdClass;
        $obj->redirect = 'something';
        $obj->redirect_type = 'back';
        $this->Framework->Redirect->shouldReceive('back')->times(1)->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('with')->times(1)->andReturn('response');
        $this->RedirectHandler->redirect($obj);
    }

    public function test_it_can_redirect_by_default()
    {
        $obj = new \stdClass;
        $obj->redirect = 'something';
        $obj->redirect_type = '';
        $this->Framework->Redirect->shouldReceive('back')->times(1)->andReturnSelf();
        $this->Framework->Redirect->shouldReceive('with')->times(1)->andReturn('response');
        $this->RedirectHandler->redirect($obj);
    }
}