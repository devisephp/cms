<?php namespace Devise\Media\Encoding;

use Mockery as m;

class EncodingServiceProviderTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
        $app = m::mock('Illuminate\Container\Container');
        new EncodingServiceProvider($app);
    }
}