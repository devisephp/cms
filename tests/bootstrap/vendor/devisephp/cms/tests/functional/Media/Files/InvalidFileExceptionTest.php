<?php namespace Devise\Media\Files;

use Mockery as m;

class InvalidFileExceptionTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
        new InvalidFileException;
    }
}