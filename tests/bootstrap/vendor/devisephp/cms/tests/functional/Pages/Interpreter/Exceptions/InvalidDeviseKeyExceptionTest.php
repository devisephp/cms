<?php namespace Devise\Pages\Interpreter\Exceptions;

class InvalidDeviseKeyExceptionTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function test_it_constructs()
    {
        new InvalidDeviseKeyException();
    }
}