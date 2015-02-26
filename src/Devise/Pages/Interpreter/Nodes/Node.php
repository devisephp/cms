<?php namespace Devise\Pages\Interpreter\Nodes;

/**
 * A node is a piece of string/code from the blade
 * template that we parsed out and identiied it as
 * having some special signfigance. It could be a
 * if/foreach block or even a devise tag.
 *
 * @package Devise\Pages\Interpreter\Nodes
 */
class Node
{
    /**
     * string that was matched by regex pattern
     *
     * @var position
     */
    public $matched;

    /**
     * Keeps up with the position where regex
     * match was found
     *
     * @var $position
     */
    public $position;

    /**
     * Creates a new Node object
     *
     * @param string $matched
     * @param integer $position
     */
    public function __construct($matched, $position)
	{
		$this->matched = $matched;
		$this->position = $position;
	}
}