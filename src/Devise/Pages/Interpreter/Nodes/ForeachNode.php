<?php namespace Devise\Pages\Interpreter\Nodes;

/**
 * Class ForeachNode is a node that matches
 * "@foreach" in the html/blade view
 *
 * @package Devise\Pages\Interpreter\Nodes
 */
class ForeachNode extends Node
{
    /**
     * This is the node name
     *
     * @var string
     */
    public $node = 'foreach';

    /**
     * This is the type of node so that
     * we know how to use this later in our
     * DeviseBladeCompiler
     *
     * @var string
     */
	public $type = 'block';
}