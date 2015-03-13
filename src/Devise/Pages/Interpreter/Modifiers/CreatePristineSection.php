<?php namespace Devise\Pages\Interpreter\Modifiers;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Node\Stmt\InlineHTML;
use Devise\Pages\Interpreter\DeviseParser;

/**
 * this creates two sections, one for devise editors
 * and the other a pristine section which removes
 * all the data-devise stuff...
 */
class CreatePristineSection extends NodeVisitorAbstract
{
	/**
	 * Cloned AST...
	 *
	 * @var array
	 */
	protected $cloned = [];

	/**
	 * [__construct description]
	 * @param DeviseParser $DeviseParser
	 */
	public function __construct(DeviseParser $DeviseParser)
	{
		$this->DeviseParser = $DeviseParser;
	}

	/**
	 * Removes the devise tag stuff
	 *
	 * @param  Node   $node
	 * @return void
	 */
	public function enterNode(Node $node)
	{
		if ($node instanceof InlineHTML)
		{
			$node->value = $this->parseNode($node->value);
		}
	}

	/**
	 * Runs after all the nodes have been examined
	 *
	 * @param  array  $nodes
	 * @return array
	 */
	public function beforeTraverse(array $nodes)
	{
		foreach ($nodes as $node)
		{
			$this->cloned[] = clone $node;
		}
	}

	/**
	 * After we traverse the tree, we are going to
	 * split the view into two parts. The first part
	 * is for devise editors and the second part
	 * is for pristine viewers
	 *
	 * @param  array  $nodes
	 * @return array
	 */
	public function afterTraverse(array $nodes)
	{
		$stmts = $this->DeviseParser->parse("<?php if (DeviseUser::checkConditions('canUseDeviseEditor')): ?>{{ devisehere }}<?php else: ?>{{ pristinehere}}<?php endif ?>");

		$stmts[0]->stmts = $this->cloned;

		$stmts[0]->else->stmts = $nodes;

		return $stmts;
	}

	/**
	 * Parses the html node
	 *
	 * @param  string $html
	 * @return string
	 */
	protected function parseNode($html)
	{
		$tags = $this->DeviseParser->getDeviseTags($html);

		foreach ($tags as $tag)
		{
			$html = str_replace($tag->value, '', $html);
		}

		return $html;
	}
}