<?php namespace Devise\Pages\Interpreter\Modifiers;

use Mockery as m;
use PhpParser\NodeTraverser;
use Devise\Pages\Interpreter\DeviseParser;

class EchoDeviseMagicTest extends \DeviseTestCase
{
	public function test_it_can_traverse_nodes()
	{
		$parser = new DeviseParser;
		$traverser = new NodeTraverser;
		$traverser->addVisitor(new EchoDeviseMagic($parser));
		$nodes = $parser->parse($this->fixture('devise-views.interpret7'));
		$nodes = $traverser->traverse($nodes);
		assertCount(6, $nodes);

		// dd($nodes[0]);
		assertEquals('startdvsmagic', $nodes[0]->exprs[0]->left->left->name);
		assertEquals('dvsmagic', $nodes[0]->exprs[0]->left->right->name);
		assertEquals('enddvsmagic', $nodes[0]->exprs[0]->right->name);

		// dd($nodes[1]);
		assertEquals('startdvsmagic', $nodes[1]->exprs[0]->left->left->name);
		assertEquals('dvsmagic', $nodes[1]->exprs[0]->left->right->name);
		assertEquals('enddvsmagic', $nodes[1]->exprs[0]->right->name);

		// dd($nodes[2]);
		assertEquals('startdvsmagic', $nodes[2]->exprs[0]->left->left->name);
		assertEquals('dvsmagic', $nodes[2]->exprs[0]->left->right->name);
		assertEquals('enddvsmagic', $nodes[2]->exprs[0]->right->name);

		// dd($nodes[3]);
		assertEquals('startdvsmagic', $nodes[3]->exprs[0]->if->left->left->name);
		assertEquals('dvsmagic', $nodes[3]->exprs[0]->if->left->right->name);
		assertEquals('enddvsmagic', $nodes[3]->exprs[0]->if->right->name);

		// dd($nodes[4]);
		assertEquals('startdvsmagic', $nodes[4]->exprs[0]->left->left->left->left->name);
		assertEquals('dvsmagic', $nodes[4]->exprs[0]->left->left->left->right->name);
		assertEquals('enddvsmagic', $nodes[4]->exprs[0]->left->left->right->name);

		// dd($nodes[5]);
		assertEquals('startdvsmagic', $nodes[5]->exprs[0]->args[0]->value->left->left->name);
		assertEquals('dvsmagic', $nodes[5]->exprs[0]->args[0]->value->left->right->name);
		assertEquals('enddvsmagic', $nodes[5]->exprs[0]->args[0]->value->right->name);
	}
}