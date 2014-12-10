<?php namespace Devise\Pages\Interrupter\Nodes;

class IfNodeTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
        $obj = new IfNode('@if(true == false)', 123);
        assertEquals('if', $obj->node);
        assertEquals('block', $obj->type);
    }
}