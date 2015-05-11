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
		assertEquals('dvsmagic', $nodes[0]->exprs[0]->name);

		// dd($nodes[1]);
		assertEquals('dvsmagic', $nodes[1]->exprs[0]->name);

		// dd($nodes[2]);
		assertEquals('dvsmagic', $nodes[2]->exprs[0]->name);

		// dd($nodes[3]);
		assertEquals('dvsmagic', $nodes[3]->exprs[0]->if->name);

		// dd($nodes[4]);
		assertEquals('dvsmagic', $nodes[4]->exprs[0]->left->left->name);

		// dd($nodes[5]);
		assertEquals('dvsmagic', $nodes[5]->exprs[0]->args[0]->value->name);
	}
}