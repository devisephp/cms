<?php namespace Devise\Pages\Interrupter\Nodes;

class EndIfNodeTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
        $obj = new EndIfNode('@endif', 124);
        assertEquals('endif', $obj->node);
        assertEquals('endblock', $obj->type);
    }
}