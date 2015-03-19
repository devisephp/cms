<?php namespace Devise\Pages\Interpreter\Modifiers;

use Mockery as m;
use PhpParser\NodeTraverser;
use Devise\Pages\Interpreter\DeviseParser;

class RegisterDeviseTagsTest extends \DeviseTestCase
{
	public function test_it_registers_devise_tags()
	{
		$parser = new DeviseParser;
		$traverser = new NodeTraverser;
		$traverser->addVisitor(new RegisterDeviseTags($parser));
		$nodes = $parser->parse($this->fixture('devise-views.interpret3'));
		$nodes = $traverser->traverse($nodes);
	 	assertInstanceOf('PhpParser\Node\Expr\MethodCall', $nodes[0]);
	 	assertInstanceOf('PhpParser\Node\Expr\MethodCall', $nodes[1]);
	 	assertInstanceOf('PhpParser\Node\Stmt\TryCatch', $nodes[2]);
	 	assertInstanceOf('PhpParser\Node\Expr\MethodCall', $nodes[3]);
	 	assertInstanceOf('PhpParser\Node\Stmt\TryCatch', $nodes[4]);
	 	assertInstanceOf('PhpParser\Node\Expr\MethodCall', $nodes[5]);
	 	assertInstanceOf('PhpParser\Node\Stmt\TryCatch', $nodes[6]);
	 	assertInstanceOf('PhpParser\Node\Expr\MethodCall', $nodes[7]);
	 	assertInstanceOf('PhpParser\Node\Stmt\TryCatch', $nodes[8]);
	}

	public function test_it_renames_devise_tags()
	{
		$parser = new DeviseParser;
		$traverser = new NodeTraverser;
		$traverser->addVisitor(new RegisterDeviseTags($parser));
		$nodes = $parser->parse($this->fixture('devise-views.interpret3'));
		$nodes = $traverser->traverse($nodes);
	 	assertContains('<body>', $nodes[9]->value);
	 	assertInstanceOf('PhpParser\Node\Stmt\Foreach_', $nodes[10]);
	 	assertContains('<div data-devise-<?php echo devise_tag_cid(\'key1\', "field", null, "key1", "type", "Human name 1", null, null, null, null) ?>="key1">Hello there #1</div>', $nodes[10]->stmts[0]->value);
	 	assertContains('<div data-devise-<?php echo devise_tag_cid(\'key2\', "field", null, "key2", "type", "Human name 2", null, null, null, null) ?>="key2">Hello there #2</div>', $nodes[10]->stmts[1]->stmts[0]->value);
	 	assertContains('<p data-devise-<?php echo devise_tag_cid(\'outside\', "field", null, "outside", "type", "Outside Key", null, null, null, null) ?>="outside">', $nodes[11]->value);
	}
}