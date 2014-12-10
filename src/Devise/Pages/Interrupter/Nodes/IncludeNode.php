<?php namespace Devise\Pages\Interrupter\Nodes;

/**
 * Class IncludeNode is a node that matches
 * "@include (...)" in the html/blade view
 *
 * @package Devise\Pages\Interrupter\Nodes
 */
class IncludeNode extends Node
{
    /**
     * This is the node name
     *
     * @var string
     */
    public $node = 'include';

    /**
     * This is the type of node so that
     * we know how to use this later in our
     * DeviseBladeCompiler
     *
     * @var string
     */
	public $type = 'include';
}