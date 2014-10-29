<?php namespace Devise\Pages\Interrupter;

use Devise\Pages\Interrupter\Nodes\NodeFactory;

/**
 * the purpose this class is to take a blade view and
 * abstract out all the @if, @foreach blocks and put them
 * into a composite pattern structure so we can use those
 * blocks later to print off devise placeholder tags
 */
class BlockFactory
{
	/**
	 * Create a new block factory
	 *
	 * @param NodeFactory $NodeFactory
	 * @param ViewOpener $ViewOpener
	 */
	public function __construct(NodeFactory $NodeFactory, ViewOpener $ViewOpener)
	{
		$this->NodeFactory = $NodeFactory;
		$this->ViewOpener = $ViewOpener;
	}

	/**
	 * Creates a block from the given view
	 *
	 * @param  string $view
	 * @return Block
	 */
	public function createBlock($view, $includedViews = [])
	{
		$matches = $this->nodes($view);

		$block = $this->newBlock($includedViews);

		return $this->populateBlock($matches, $block);
	}

	/**
	 * Creates a new block instance
	 *
	 * @return Block
	 */
	protected function newBlock($includedViews)
	{
		$block = new Block;

		$block->includedViews = $includedViews;

		return $block;
	}

	/**
	 * Recursively populate this block with nodes inside of
	 * the stack.
	 *
	 * @param  array $stack
	 * @param  Block $block
	 * @return $block
	 */
	protected function populateBlock(&$stack, $block)
	{
		while (count($stack) > 0)
		{
			$node = array_shift($stack);

			switch ($node->type)
			{
				case 'tag':
					$block->addTag($node);
				break;

				case 'block':
					$newBlock = $this->newBlock($block->includedViews);
					$newBlock->start($node);
					$block->addBlock($this->populateBlock($stack, $newBlock));
				break;

				case 'endblock':
					$block->stop($node);
					return $block;
				break;

				case 'include':
					$block->addBlock($this->includeBlock($node, $block->includedViews));
				break;
			}
		}

		return $block;
	}

	public static $overflow = 0;

	/**
	 * Opens a view for an @include block
	 * for a given node
	 *
	 * @param  Node $node
	 * @return Block
	 */
	protected function includeBlock($node, $includedViews)
	{
		$viewpath = $node->matched;

		$view = $this->ViewOpener->open($viewpath, $includedViews);

		$block = $this->createBlock($view, $includedViews);

		$block->start($node);

		return $block;
	}

	/**
	 * Gets all the starting, ending include and devise tag matches
	 * which we call 'nodes'
	 *
	 * @param  string $view
	 * @return array
	 */
	protected function nodes($view)
	{
		$startingMatches = $this->startingMatches($view);

		$endingMatches = $this->endingMatches($view);

		$includeMatches = $this->includeMatches($view);

		$deviseMatches = $this->deviseMatches($view);

		return $this->sortMatches([$startingMatches, $endingMatches, $includeMatches, $deviseMatches]);
	}

	/**
	 * Find matches in this view for this given regex pattern
	 *
	 * @param  string $view
	 * @param  regex  $pattern
	 * @return array
	 */
	protected function matches($view, $pattern)
	{
		preg_match_all($pattern, $view, $matches, PREG_OFFSET_CAPTURE);

		if (!isset($matches[0])) return array();

		return $matches[0];
	}

	/**
	 * Finds matches that start @if or @foreach blocks
	 *
	 * @param  string $view
	 * @return array
	 */
	protected function startingMatches($view)
	{
		return $this->matches($view, '/(@if ?\(|@foreach ?\()/');
	}

	/**
	 * Finds matches that end the @if or @foreach blocks
	 *
	 * @param  string $view
	 * @return array
	 */
	protected function endingMatches($view)
	{
		return $this->matches($view, '/(@endif|@endforeach)/');
	}

	/**
	 * Finds matches that have @include in them
	 *
	 * @param  string $view
	 * @return array
	 */
	protected function includeMatches($view)
	{
		return $this->matches($view, '/(@include ?\([^\)]*\))/');
	}

	/**
	 * Finds matches that contain data-devise tags
	 *
	 * @param  string $view
	 * @return array
	 */
	protected function deviseMatches($view)
	{
		return $this->matches($view, "/ data-devise(-[0-9]+)?=[\"|']([^\"']*)[\"|']/");
	}

	/**
	 * Finds matches that start with @if or @foreach
	 *
	 * @param  string $view
	 * @return array
	 */
	protected function sortMatches($allMatches)
	{
		$nodes = [];

		foreach ($allMatches as $matches)
		{
			foreach ($matches as $match)
			{
				$nodes[] = $this->NodeFactory->createNodeFromRegexMatch($match);
			}
		}

		// sort the nodes by position in the view
		usort($nodes, function ($node1, $node2)
		{
			return $node1->position > $node2->position ? 1 : -1;
		});

		return $nodes;
	}
}