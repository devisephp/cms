<?php namespace Devise\Pages\Interpreter\Nodes;

/**
 * Class EndForeachNode is a node that matches
 * "@endforeach" in the html/blade view
 *
 * @package Devise\Pages\Interpreter\Nodes
 */
class EndForeachNode extends Node
{
    /**
     * This is the node name
     *
     * @var string
     */
	public $node = 'endforeach';

    /**
     * This is the type of node so that
     * we know how to use this later in our
     * DeviseBladeCompiler
     *
     * @var string
     */
	public $type = 'endblock';
}