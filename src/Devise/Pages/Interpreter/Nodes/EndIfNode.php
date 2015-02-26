<?php namespace Devise\Pages\Interpreter\Nodes;

/**
 * Class EndIfNode is a node that matches
 * "@endif" in the html/blade view
 *
 * @package Devise\Pages\Interpreter\Nodes
 */
class EndIfNode extends Node
{
    /**
     * This is the node name
     *
     * @var string
     */
    public $node = 'endif';

    /**
     * This is the type of node so that
     * we know how to use this later in our
     * DeviseBladeCompiler
     *
     * @var string
     */
    public $type = 'endblock';
}