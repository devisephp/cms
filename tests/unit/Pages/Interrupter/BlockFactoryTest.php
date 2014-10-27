<?php namespace Devise\Pages\Interrupter;

class BlockFactoryTest extends \DeviseTestCase
{
	public function setUp()
	{
		$viewOpener = $this->getMock('Devise\Pages\Interrupter\ViewOpener');

		$viewOpener->method('open')->willReturn($this->fixture('devise-views.view2'));

		$this->factory = new BlockFactory(new Nodes\NodeFactory, $viewOpener);
	}

	public function test_it_can_create_a_new_block_from_view3()
	{
		$block = $this->factory->createBlock($this->fixture('devise-views.view3'));

		assertEquals(5, count($block->getTags()));
		assertEquals(4, count($block->getBlocks()));
	}
}