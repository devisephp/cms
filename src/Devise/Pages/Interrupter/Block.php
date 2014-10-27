<?php namespace Devise\Pages\Interrupter;

class Block
{
	public $type;

	protected $start, $stop, $childBlocks, $tags;

	public function __construct()
	{
		$this->childBlocks = [];
		$this->tags = [];
	}

	public function start($node)
	{
		$this->type = $node->type;
		$this->start = $node;
	}

	public function stop($node)
	{
		$this->stop = $node;
	}

	public function addTag($node)
	{
		$this->tags[] = new DeviseTag($node);
	}

	public function addBlock(Block $node)
	{
		$this->childBlocks[] = $node;
	}

	public function getStartingPosition()
	{
		return $this->start->position;
	}

	public function getStartBlock()
	{
		return $this->start;
	}

	public function getStopBlock()
	{
		return $this->stop;
	}

	public function getBlocks()
	{
		return $this->childBlocks;
	}

	public function getTags($includeTypes = ['block'])
	{
		$tags = $this->tags;

		foreach ($this->childBlocks as $childBlock)
		{
			if (in_array($childBlock->type, $includeTypes))
			{
				$tags = array_merge($tags, $childBlock->getTags());
			}
		}

		return $tags;
	}
}