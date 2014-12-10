<?php namespace Devise\Media\Encoding;

use Mockery as m;

class ZencoderNotificationsControllerTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
        $encoder = m::mock('Devise\Media\Encoding\ZencoderJob');
        $encoder->shouldReceive('handle')->times(1);
        $app = m::mock('Illuminate\Container\Container');
        $app->shouldReceive('make')->times(1)->with('devise.video.encoder')->andReturn($encoder);
        $response = m::mock('Illuminate\Http\Response');
        $response->shouldReceive('json')->andReturn('thanks zencoder');
        $input = m::mock('Illuminate\Http\Request');
        $input->shouldReceive('get')->andReturn(['something here']);
        $controller = new ZencoderNotificationsController($app, $response, $input);
        $controller->store();
    }
}