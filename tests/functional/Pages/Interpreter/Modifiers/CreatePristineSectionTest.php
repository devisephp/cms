<?php namespace Devise\Pages\Interpreter\Modifiers;

use Mockery as m;
use PhpParser\NodeTraverser;
use Devise\Pages\Interpreter\DeviseParser;

class CreatePristineSectionTest extends \DeviseTestCase
{
	public function test_it_creates_pristine_section()
	{
		$parser = new DeviseParser;
		$traverser = new NodeTraverser;
		$traverser->addVisitor(new CreatePristineSection($parser));
		$nodes = $parser->parse($this->fixture('devise-views.interpret3'));
		$nodes = $traverser->traverse($nodes);
		assertCount(1, $nodes);
		assertInstanceOf('PhpParser\Node\Stmt\If_', $nodes[0]);
	}
}