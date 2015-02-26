<?php namespace Devise\Pages\Interpreter\Nodes;

class NodeTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
        $obj = new Node("", 123);
        assertEquals("", $obj->matched);
        assertEquals(123, $obj->position);
    }
}