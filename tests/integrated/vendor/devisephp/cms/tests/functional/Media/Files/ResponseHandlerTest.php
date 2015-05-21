<?php namespace Devise\Media\Files;

use Mockery as m;

class ResponseHandlerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->FileManager = m::mock('Devise\Media\Files\Manager');
        $this->Redirect = m::mock('Illuminate\Http\Redirect');
        $this->ResponseHandler = new ResponseHandler($this->FileManager, $this->Redirect);
    }

    public function test_it_handles_upload_request()
    {
        $this->FileManager->shouldReceive('saveUploadedFile')->times(1);
        $this->Redirect->shouldReceive('back')->times(1)->andReturn('something');
        $this->ResponseHandler->requestUpload([]);
    }

    public function test_it_handles_rename_request()
    {
        $this->FileManager->shouldReceive('renameUploadedFile')->times(1);
        $this->ResponseHandler->requestRename([]);
    }

    public function test_it_handles_remove_request()
    {
        $this->FileManager->shouldReceive('removeUploadedFile')->times(1)->andReturn(true);
        $this->ResponseHandler->requestRemove([]);
    }
}