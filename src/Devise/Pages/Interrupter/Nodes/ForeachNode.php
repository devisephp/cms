<?php namespace Devise\Pages\Interrupter\Nodes;

/**
 * Class ForeachNode is a node that matches
 * "@foreach" in the html/blade view
 *
 * @package Devise\Pages\Interrupter\Nodes
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