<?php namespace Devise\Pages\Interrupter\Nodes;

/**
 * Class IfNode is a node that matches
 * "@if (...)" in the html/blade view
 *
 * @package Devise\Pages\Interrupter\Nodes
 */
class IfNode extends Node
{
    /**
     * This is the node name
     *
     * @var string
     */
    public $node = 'if';

    /**
     * This is the type of node so that
     * we know how to use this later in our
     * DeviseBladeCompiler
     *
     * @var string
     */
	public $type = 'block';
}