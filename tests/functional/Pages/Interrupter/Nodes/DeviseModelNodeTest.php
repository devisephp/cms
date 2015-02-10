<?php namespace Devise\Pages\Interrupter\Nodes;

class DeviseModelNodeTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
        $obj = new DeviseModelNode(' data-devise="$post, human name"', 304);
        assertEquals('devisemodel', $obj->node);
        assertEquals('model', $obj->type);
    }
}