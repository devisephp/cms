<?php namespace Devise\Support;

use Mockery as m;

class DeviseValidationExceptionTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
        new DeviseValidationException("Some message", m::mock('Illuminate\Support\MessageBag'));
    }
}