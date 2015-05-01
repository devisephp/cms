<?php namespace Devise\Pages\Interpreter\Modifiers;

use PhpParser\NodeVisitorAbstract;
use PhpParser\Node;
use PhpParser\Node\Stmt\If_;
use PhpParser\Node\Stmt\For_;
use PhpParser\Node\Stmt\Foreach_;
use PhpParser\Node\Stmt\InlineHTML;
use Devise\Pages\Interpreter\DeviseParser;

/**
 * This visitor class handles putting
 */
class AddPlaceHolderTags extends NodeVisitorAbstract
{
	/**
	 * [__construct description]
	 * @param DeviseParser $DeviseParser
	 */
	public function __construct(DeviseParser $DeviseParser)
	{
		$this->DeviseParser = $DeviseParser;
	}

	/**
	 * Runs after all the nodes have been examined
	 *
	 * @param  array  $nodes
	 * @return array
	 */
	public function afterTraverse(array $nodes)
	{
		$modified = [];

		foreach ($nodes as $index => $node)
		{
			$tags = $this->findTagsInsideOfNode($node);

			if (count($tags) > 0)
			{
				$modified[] = $this->createPlaceHolderNodeFromTags($tags);
			}

			$modified[] = $node;
		}

		return $modified;
	}

	/**
	 * Create the placeholder nodes from the listed tags
	 *
	 * @param  array $tags
	 * @return InlineHTML
	 */
	protected function createPlaceHolderNodeFromTags($tags)
	{
		$placeholders = '';

		foreach ($tags as $tag)
		{
			$placeholders .= " data-dvs-placeholder=\"{$tag->id}\"";
		}

		return new InlineHTML("<span{$placeholders}></span>");
	}

	/**
	 * Gets a list of tags inside of a node
	 *
	 * @param  Node $node
	 * @return array
	 */
	protected function findTagsInsideOfNode($node)
	{
		if ($node instanceof If_)
		{
			return $this->findTagsInsideOfCondition($node);
		}

		if ($node instanceof For_ || $node instanceof Foreach_)
		{
			return $this->findTagsInsideOfLoop($node);
		}

		return [];
	}

	/**
	 * Gets a list of tags inside of a condition
	 *
	 * @param  If_  $node
	 * @return array
	 */
	protected function findTagsInsideOfCondition($node)
	{
		list ($node->stmts, $tags) = $this->findTagsInsideOfStmts($node->stmts);

		if ($node->else && $node->else->stmts)
		{
			list ($node->else->stmts, $elseTags) = $this->findTagsInsideOfStmts($node->else->stmts);

			$tags = array_merge($tags, $elseTags);
		}

		foreach ($node->elseifs as $index => $elseif)
		{
			list ($node->elseifs[$index]->stmts, $elseIfTags) = $this->findTagsInsideOfStmts($node->elseifs[$index]->stmts);

			$tags = array_merge($tags, $elseIfTags);
		}

		return $tags;
	}

	/**
	 * Returns a list of tags inside of loop
	 *
	 * @param  Foreach_ || For_ $node
	 * @return array
	 */
	protected function findTagsInsideOfLoop($node)
	{
		list ($node->stmts, $tags) = $this->findTagsInsideOfStmts($node->stmts);

		return $tags;
	}

	/**
	 * Finds all the tags inside of stmts and also recursively
	 * modifies the AST putting placeholder tags all the way
	 * down in the tree (for nested loops and conditions)
	 *
	 * @param  array $stmts
	 * @return array
	 */
	protected function findTagsInsideOfStmts($stmts)
	{
		$tags = [];

		$modified = [];

		foreach ($stmts as $stmt)
		{
			//
			// if this is an If_ statement then we might have
			// more nested tags underneath this thing
			//
			if ($stmt instanceof If_)
			{
				$nestedTags = $this->findTagsInsideOfCondition($stmt);

				if ($nestedTags) $modified[] = $this->createPlaceHolderNodeFromTags($nestedTags);

				$tags = array_merge($tags, $nestedTags);
			}

			//
			// if this is a loop statement then we might have
			// more nested tags underneath this thing
			//
			if ($stmt instanceof For_ || $stmt instanceof Foreach_)
			{
				$nestedTags = $this->findTagsInsideOfLoop($stmt);

				if ($nestedTags) $modified[] = $this->createPlaceHolderNodeFromTags($nestedTags);

				$tags = array_merge($tags, $nestedTags);
			}

			//
			// finally, we have html that we can look for devise tags
			// inside of
			//
			if ($stmt instanceof InlineHTML)
			{
				$tags = array_merge($tags, $this->DeviseParser->getDeviseTags($stmt->value));
			}

			// we need to add this statement to the AST
			$modified[] = $stmt;
		}

		// returns modified AST and list of all tags
		return array($modified, $tags);
	}
}