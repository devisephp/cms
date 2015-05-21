<?php namespace Devise\Pages;

use Mockery as m;

class ApiPageResponseHandlerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->ApiPagesManager = m::mock('Devise\Pages\ApiPagesManager');
        $this->Redirect = m::mock('Illuminate\Routing\Redirector');
        $this->ApiPagesResponseHandler = new ApiPagesResponseHandler($this->ApiPagesManager, $this->Redirect);
    }

    public function test_it_can_request_new_page_creation()
    {
        $this->ApiPagesManager->shouldReceive('createNewPage')->times(1)->andReturn(new \DvsPage);
        $this->Redirect->shouldReceive('route')->times(1);
        $this->ApiPagesResponseHandler->requestCreateNewPage(['some' => 'fake input']);
    }

    public function test_it_cannot_request_invalid_page_creation()
    {
        $this->ApiPagesManager->errors = [];
        $this->ApiPagesManager->message = 'There was an error';
        $this->ApiPagesManager->shouldReceive('createNewPage')->times(1)->andReturn(false);
        $this->Redirect->shouldReceive('route')->times(1)->andReturnSelf();
        $this->Redirect->shouldReceive('withInput')->times(1)->andReturnSelf();
        $this->Redirect->shouldReceive('withErrors')->times(1)->andReturnSelf();
        $this->Redirect->shouldReceive('with')->times(1)->andReturnSelf();
        $this->ApiPagesResponseHandler->requestCreateNewPage(['some' => 'fake input']);
    }

    public function test_it_can_request_page_updates()
    {
        $this->ApiPagesManager->shouldReceive('updatePage')->times(1)->andReturn(new \DvsPage);
        $this->Redirect->shouldReceive('route')->times(1);
        $this->ApiPagesResponseHandler->requestUpdatePage(1, ['some' => 'fake input']);
    }

    public function test_it_cannot_request_invalid_page_update()
    {
        $this->ApiPagesManager->errors = [];
        $this->ApiPagesManager->message = 'There was an error';
        $this->ApiPagesManager->shouldReceive('updatePage')->times(1)->andReturn(false);
        $this->Redirect->shouldReceive('route')->times(1)->andReturnSelf();
        $this->Redirect->shouldReceive('withInput')->times(1)->andReturnSelf();
        $this->Redirect->shouldReceive('withErrors')->times(1)->andReturnSelf();
        $this->Redirect->shouldReceive('with')->times(1)->andReturnSelf();
        $this->ApiPagesResponseHandler->requestUpdatePage(1, ['some' => 'fake input']);
    }

    public function test_it_can_request_page_deletion()
    {
        $this->ApiPagesManager->shouldReceive('destroyPage')->times(1)->andReturn(true);
        $this->Redirect->shouldReceive('route')->times(1)->andReturnSelf();
        $this->Redirect->shouldReceive('with')->times(1);
        $this->ApiPagesResponseHandler->requestDestroyPage(1);
    }
}