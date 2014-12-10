<?php namespace Devise\Pages\Interrupter\Nodes;

class UnidentifiedNodeExceptionTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
        new UnidentifiedNodeException();
    }
}