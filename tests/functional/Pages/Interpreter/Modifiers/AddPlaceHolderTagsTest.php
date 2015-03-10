<?php namespace Devise\Pages\Interpreter\Modifiers;

use Mockery as m;
use PhpParser\NodeTraverser;
use Devise\Pages\Interpreter\DeviseParser;

class AddPlaceHolderTagsTest extends \DeviseTestCase
{
	public function test_it_can_traverse_nodes()
	{
		$parser = new DeviseParser;
		$traverser = new NodeTraverser;
		$traverser->addVisitor(new AddPlaceHolderTags($parser));
		$nodes = $parser->parse($this->fixture('devise-views.interpret3'));
		$nodes = $traverser->traverse($nodes);
		assertCount(4, $nodes);
		assertEquals('<span data-dvs-placeholder="key1" data-dvs-placeholder="key2" data-dvs-placeholder="key3"></span>', $nodes[1]->value);
	}
}