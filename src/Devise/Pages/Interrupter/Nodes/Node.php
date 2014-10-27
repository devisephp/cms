<?php namespace Devise\Pages\Interrupter\Nodes;

class Node
{
	public $matched, $position;

	public function __construct($matched, $position)
	{
		$this->matched = $matched;
		$this->position = $position;
	}
}