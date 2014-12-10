<?php namespace Devise\Pages\Interrupter\Nodes;

class NodeFactoryTest extends \DeviseTestCase
{
    public function test_it_creates_if_node()
    {
        $factory = new NodeFactory;
        $node = $factory->createNodeFromRegexMatch(['@if ($thing == false)', 123]);
        assertInstanceOf('Devise\Pages\Interrupter\Nodes\IfNode', $node);
    }

    public function test_it_creates_foreach_node()
    {
        $factory = new NodeFactory;
        $node = $factory->createNodeFromRegexMatch(['@foreach($things as $thing)', 123]);
        assertInstanceOf('Devise\Pages\Interrupter\Nodes\ForeachNode', $node);
    }

    public function test_it_creates_devise_tag_node()
    {
        $factory = new NodeFactory;
        $node = $factory->createNodeFromRegexMatch([' data-devise="key1, image"', 123]);
        assertInstanceOf('Devise\Pages\Interrupter\Nodes\DeviseTagNode', $node);
    }

    public function test_it_creates_end_if_node()
    {
        $factory = new NodeFactory;
        $node = $factory->createNodeFromRegexMatch(['@endif', 123]);
        assertInstanceOf('Devise\Pages\Interrupter\Nodes\EndIfNode', $node);
    }

    public function test_it_creates_end_foreach_node()
    {
        $factory = new NodeFactory;
        $node = $factory->createNodeFromRegexMatch(['@endforeach', 123]);
        assertInstanceOf('Devise\Pages\Interrupter\Nodes\EndForeachNode', $node);
    }

    public function test_it_creates_include_node()
    {
        $factory = new NodeFactory;
        $node = $factory->createNodeFromRegexMatch(['@include("some.path")', 123]);
        assertInstanceOf('Devise\Pages\Interrupter\Nodes\IncludeNode', $node);
    }

    /**
     * @expectedException Devise\Pages\Interrupter\Nodes\UnidentifiedNodeException
     */
    public function test_it_throws_an_exception_for_unknown_node_type()
    {
        $factory = new NodeFactory;
        $node = $factory->createNodeFromRegexMatch(['unknown node homie!', 123]);
    }
}