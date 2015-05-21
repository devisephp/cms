<?php namespace Devise\Pages\Interpreter\Exceptions;

class DuplicateDeviseKeyExceptionTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function test_it_constructs()
    {
        new DuplicateDeviseKeyException();
    }
}