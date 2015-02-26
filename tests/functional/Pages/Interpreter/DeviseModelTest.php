<?php namespace Devise\Pages\Interpreter;

class DeviseModelTest extends \DeviseTestCase
{
	protected function tag($deviseTag, $position = 0)
	{
		$node = new Nodes\DeviseModelNode($deviseTag, $position);
		return new DeviseModel($node);
	}

	public function test_it_can_be_created_from_node()
	{
		$tag = $this->tag(' data-devise="$post, human name"', 19);

		assertEquals('$post', $tag->model);
		assertEquals('human name', $tag->humanName);
		assertEquals(null, $tag->collection);
	}

}