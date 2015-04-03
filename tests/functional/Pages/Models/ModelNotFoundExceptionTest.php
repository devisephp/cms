<?php namespace Devise\Pages\Models;

use Mockery as m;

class ModelNotFoundExceptionTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function test_it_can_constructs()
    {
        new ModelNotFoundException;
    }
}