<?php namespace Devise\Pages\Interrupter\Exceptions;

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