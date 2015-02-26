<?php namespace Devise\Pages\Interpreter\Nodes;

class ForeachNodeTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
        $obj = new ForeachNode('@foreach($things as $thing)', 124);
        assertEquals('foreach', $obj->node);
        assertEquals('block', $obj->type);
    }
}