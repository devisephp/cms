<?php namespace Devise\Pages\Interrupter\Nodes;

class IncludeNodeTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
        $obj = new IncludeNode('@include("some.view.path")', 304);
        assertEquals('include', $obj->node);
        assertEquals('include', $obj->type);
    }
}