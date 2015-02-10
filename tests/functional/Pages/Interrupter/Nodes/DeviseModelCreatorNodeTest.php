<?php namespace Devise\Pages\Interrupter\Nodes;

class DeviseModelCreatorNodeTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
        $obj = new DeviseModelCreatorNode(' data-devise-create-model="DvsUser"', 304);
        assertEquals('devisemodelcreator', $obj->node);
        assertEquals('model_creator', $obj->type);
    }
}