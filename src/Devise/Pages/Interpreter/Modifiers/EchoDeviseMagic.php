<?php namespace Devise\Pages\Interpreter\Modifiers;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Node\Stmt\Echo_;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Expr\PropertyFetch;
use PhpParser\Node\Expr\Ternary;
use PhpParser\Node\Expr\BinaryOp\Concat;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Arg;
use Devise\Pages\Interpreter\DeviseParser;

class EchoDeviseMagic extends NodeVisitorAbstract
{
	/**
	 * Create a new EchoDeviseMagic visitor
	 *
	 * @param DeviseParser $DeviseParser
	 */
	public function __construct(DeviseParser $DeviseParser)
	{
		$this->DeviseParser = $DeviseParser;
	}

	/**
	 * We need to look for different types of nodes inside
	 * of echo nodes only
	 *
	 * @param  Node   $node
	 * @return Node
	 */
	public function enterNode(Node $node)
	{
		if ($node instanceof Echo_)
		{
			$node = $this->traverseIntoEchoStatement($node);
		}

		return $node;
	}

	/**
	 * Looks inside of this echo for valid combinations.
	 * This is a context free grammar tree at this point...
	 *
	 * @param  Echo_  $node
	 * @return Echo_
	 */
	protected function traverseIntoEchoStatement(Echo_ $node)
	{
		$exprs = [];

		foreach ($node->exprs as $expr)
		{
			$exprs[] = $this->examineExpression($expr);
		}

		$node->exprs = $exprs;
	}

	/**
	 * Determines what to do with this expression
	 *
	 * @param  [type] $expr
	 * @return [type]
	 */
	protected function examineExpression($node)
	{
		if ($node instanceof Variable)
		{
			return $this->wrapNodeWithMagicMethods($node);
		}

		if ($node instanceof PropertyFetch)
		{
			return $this->wrapNodeWithMagicMethods($node);
		}

		if ($node instanceof MethodCall)
		{
			return $this->wrapNodeWithMagicMethods($node);
		}

		if ($node instanceof Ternary)
		{
			$node->if = $this->examineExpression($node->if);
			$node->else = $this->examineExpression($node->else);
			return $node;
		}

		if ($node instanceof Concat)
		{
			$node->left = $this->examineExpression($node->left);
			$node->right = $this->examineExpression($node->right);
			return $node;
		}

		if ($node instanceof Arg)
		{
			$node->value = $this->examineExpression($node->value);
			return $node;
		}

		if ($node instanceof FuncCall)
		{
			return $this->examineFunction($node);
		}

		return $node;
	}

	/**
	 * Examines the function node for places
	 * to put dvsmagic() wrappers
	 *
	 * @param  Node $node
	 * @return Node
	 */
	protected function examineFunction($node)
	{
		$args = [];

		foreach ($node->args as $arg)
		{
			$args[] = $this->examineExpression($arg);
		}

		$node->args = $args;

		return $node;
	}

	/**
	 * wraps the node inside of the dvsmagic method
	 *
	 * @param  Node $node
	 * @return Node
	 */
	protected function wrapNodeWithMagicMethods($node)
	{
		$dvsmagic = $this->DeviseParser->parse('<?php startdvsmagic() . dvsmagic(false, "", false) . enddvsmagic() ?>')[0];

		$dvsmagic->left->right->args[0]->value = $node;

		if (isset($node->name))
		{
			$dvsmagic->left->right->args[1]->value->value = $node->name;
		}

		if (isset($node->var))
		{
			$dvsmagic->left->right->args[2]->value = $node->var;
		}

		$dvsmagic->args = array($node);

		return $dvsmagic;
	}

}