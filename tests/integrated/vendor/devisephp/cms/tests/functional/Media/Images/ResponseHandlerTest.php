<?php namespace Devise\Media\Images;

use Mockery as m;

class ResponseHandlerTest extends \DeviseTestCase
{
    public function test_it_handles_crop_requests()
    {
        $Manager = m::mock('Devise\Media\Images\Manager');
        $Redirect = m::mock('Illuminate\Http\Redirect');
        $URL = m::mock('Illuminate\Routing\UrlGenerator');
        $Redirect->shouldReceive('back')->times(1);
        $Manager->shouldReceive('cropAndSaveFile')->andReturn(false);
        $ResponseHandler = new ResponseHandler($Manager, $Redirect, $URL);
        $ResponseHandler->requestCrop([]);
    }
}