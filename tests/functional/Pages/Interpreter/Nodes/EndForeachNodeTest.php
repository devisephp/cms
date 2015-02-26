<?php namespace Devise\Pages\Interpreter\Nodes;

class EndForeachNodeTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
        $obj = new EndForeachNode('@foreach($some as $thing)', 14);
        assertEquals('endforeach', $obj->node);
        assertEquals('endblock', $obj->type);
    }
}