<?php namespace Devise\Media\Categories;

use Mockery as m;

class ResponseHandlerTest extends \DeviseTestCase
{
    public function setUp()
    {
        $this->Manager = m::mock('Devise\Media\Categories\Manager');
        $this->Redirect = m::mock('Illuminate\Routing\Redirector');
        $this->Redirect->shouldReceive('back')->andReturn(true);
        $this->ResponseHandler = new ResponseHandler($this->Manager, $this->Redirect);
    }

    public function test_it_can_request_store()
    {
        $this->Manager->shouldReceive('storeNewCategory')->times(1)->andReturn(true);
        $this->ResponseHandler->requestStore([]);
    }

    public function test_it_can_request_destroy()
    {
        $this->Manager->shouldReceive('destroyCategory')->times(1)->andReturn(true);
        $this->ResponseHandler->requestDestroy([]);
    }

    public function test_it_can_request_rename()
    {
        $this->Manager->shouldReceive('renameCategory')->times(1)->andReturn(true);
        $this->ResponseHandler->requestRename(['path' => 'some/path', 'newname' => 'some/renamed/path']);
    }
}
