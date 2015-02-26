<?php namespace Devise\Pages\Interpreter;

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
	 * @param ViewOpener $ViewOpener
	 */
	public function __construct(ViewOpener $ViewOpener)
	{
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
		$nodes = $this->nodes($view);

		$block = $this->newBlock($includedViews);

		return $this->populateBlock($nodes, $block);
	}

	/**
	 * Gets all the starting, ending include and devise tag and model
	 * matches which we call 'nodes'
	 *
	 * @param  string $view
	 * @return array
	 */
	protected function nodes($view)
	{
		$matches = [];

		$matches[] = $this->ifMatches($view);

		$matches[] = $this->endifMatches($view);

		$matches[] = $this->foreachMatches($view);

		$matches[] = $this->endforeachMatches($view);

		$matches[] = $this->includeMatches($view);

		$matches[] = $this->deviseMatches($view);

		$matches[] = $this->deviseModelMatches($view);

		$matches[] = $this->deviseModelCreatorMatches($view);

		return $this->sortNodes($matches);
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
	 * Sort all the nodes by their positions in the view
	 *
	 * @param  array allMatches
	 * @return array
	 */
	protected function sortNodes($allNodes)
	{
		$combined = [];

		// flatten out (combined) the nodes into 1 giant array
		foreach ($allNodes as $nodes)
		{
			foreach ($nodes as $node)
			{
				$combined[] = $node;
			}
		}

		// sort the nodes by position in the view
		usort($combined, function ($node1, $node2)
		{
			return $node1->position > $node2->position ? 1 : -1;
		});

		return $combined;
	}

	/**
	 * Recursively populate this block with nodes inside of
	 * the stack.
	 *
	 * @param  array $stack
	 * @param  Block $block
	 * @return Block
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

				case 'model':
					$block->addModel($node);
				break;

				case 'model_creator':
					$block->addModelCreator($node);
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
	 * Helper utility function that creates node classes in
	 * an array for each different matched node type, i.e.
	 * @foreach, @if, data-devise, etc
	 *
	 * @param  array $matches
	 * @param  string $nodeClass
	 * @return [type]
	 */
	protected function createNodes($matches, $nodeClass)
	{
		$nodes = [];

		foreach ($matches as $match)
		{
			$matched = $match[0];
			$position = $match[1];

			$nodes[] = new $nodeClass($matched, $position);
		}

		return $nodes;
	}

	/**
	 * Finds matches that start @if blocks
	 *
	 * @param  string $view
	 * @return array
	 */
	protected function ifMatches($view)
	{
		$matches = $this->matches($view, '/(@if ?\()/');

		return $this->createNodes($matches, 'Devise\Pages\Interpreter\Nodes\IfNode');
	}

	/**
	 * Finds matches that end the @if blocks
	 *
	 * @param  string $view
	 * @return array
	 */
	protected function endifMatches($view)
	{
		$matches = $this->matches($view, '/(@endif)/');

		return $this->createNodes($matches, 'Devise\Pages\Interpreter\Nodes\EndIfNode');
	}

	/**
	 * Finds matches that start @foreach blocks
	 *
	 * @param  string $view
	 * @return array
	 */
	protected function foreachMatches($view)
	{
		$matches = $this->matches($view, '/(@foreach ?\()/');

		return $this->createNodes($matches, 'Devise\Pages\Interpreter\Nodes\ForeachNode');
	}

	/**
	 * Finds matches that end the @foreach blocks
	 *
	 * @param  string $view
	 * @return array
	 */
	protected function endforeachMatches($view)
	{
		$matches = $this->matches($view, '/(@endforeach)/');

		return $this->createNodes($matches, 'Devise\Pages\Interpreter\Nodes\EndForeachNode');
	}

	/**
	 * Finds matches that have @include in them
	 *
	 * @param  string $view
	 * @return array
	 */
	protected function includeMatches($view)
	{
		$matches = $this->matches($view, '/(@include ?\([^\)]*\))/');

		return $this->createNodes($matches, 'Devise\Pages\Interpreter\Nodes\IncludeNode');
	}

	/**
	 * Finds matches that contain data-devise tags
	 *
	 * @param  string $view
	 * @return array
	 */
	protected function deviseMatches($view)
	{
		$matches = $this->matches($view, "/ data-devise=[\"|']([^\"'$]*)[\"|']/");

		return $this->createNodes($matches, 'Devise\Pages\Interpreter\Nodes\DeviseTagNode');
	}

	/**
	 * Matches a devise model which has a variable in it
	 *
	 * @param  string $view
	 * @return array
	 */
	protected function deviseModelMatches($view)
	{
		$matches = $this->matches($view, "/ data-devise=[\"'] *(\\$[^\"']*)[\"']/");

		return $this->createNodes($matches, 'Devise\Pages\Interpreter\Nodes\DeviseModelNode');
	}

	/**
	 * Matches a devise model creator so we can add new
	 * instances of models
	 *
	 * @param  string $view
	 * @return array
	 */
	protected function deviseModelCreatorMatches($view)
	{
		$matches = $this->matches($view, "/ data-devise-create-model=[\"'] *([^\"'])*[\"']/");

		return $this->createNodes($matches, 'Devise\Pages\Interpreter\Nodes\DeviseModelCreatorNode');
	}
}