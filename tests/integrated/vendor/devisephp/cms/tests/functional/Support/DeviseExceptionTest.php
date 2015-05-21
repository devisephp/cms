<?php namespace Devise\Support;

class DeviseExceptionTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
        new DeviseException;
    }
}