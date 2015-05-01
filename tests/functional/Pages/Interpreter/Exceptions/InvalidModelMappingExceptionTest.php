<?php namespace Devise\Pages\Interpreter\Exceptions;

class InvalidModelMappingExceptionTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function test_it_constructs()
    {
        new InvalidModelMappingException();
    }
}