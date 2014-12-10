<?php namespace Devise\Pages\Interrupter\Nodes;

class DeviseTagNodeTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
        $obj = new DeviseTagNode(' data-devise="key1, image"', 304);
        assertEquals('devisetag', $obj->node);
        assertEquals('tag', $obj->type);
    }
}