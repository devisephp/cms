<?php namespace Devise\Pages\Interpreter\Nodes;

/**
 * Class DeviseTagNode is a node that matches
 * " data-devise=..." in the html/blade view
 *
 * @package Devise\Pages\Interpreter\Nodes
 */
class DeviseModelCreatorNode extends Node
{
    /**
     * This is the node name
     *
     * @var string
     */
    public $node = 'devisemodelcreator';

    /**
     * This is the type of node so that
     * we know how to use this later in our
     * DeviseBladeCompiler
     *
     * @var string
     */
    public $type = 'model_creator';
}