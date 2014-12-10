<?php namespace Devise\Pages\Interrupter\Nodes;

/**
 * Class DeviseTagNode is a node that matches
 * " data-devise=..." in the html/blade view
 *
 * @package Devise\Pages\Interrupter\Nodes
 */
class DeviseTagNode extends Node
{
    /**
     * This is the node name
     *
     * @var string
     */
    public $node = 'devisetag';

    /**
     * This is the type of node so that
     * we know how to use this later in our
     * DeviseBladeCompiler
     *
     * @var string
     */
    public $type = 'tag';
}