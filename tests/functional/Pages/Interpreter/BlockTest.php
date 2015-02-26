<?php namespace Devise\Pages\Interpreter;

use Mockery as m;

class BlockTest extends \DeviseTestCase
{
	public function test_block_can_be_started_with_a_node()
	{
        $obj = new Block;
        $node = m::mock('Devise\Pages\Interpreter\Nodes\IfNode');
        $obj->start($node);
	}

	public function test_block_can_be_stopped_with_a_node()
	{
        $obj = new Block;
        $node = m::mock('Devise\Pages\Interpreter\Nodes\EndIfNode');
        $obj->stop($node);
	}

	public function test_block_can_add_devise_tags()
	{
        $obj = new Block;
        $node = m::mock('Devise\Pages\Interpreter\Nodes\DeviseTagNode');
        $node->matched = ' data-devise="key1, image"';
        $node->position = 42;
        $obj->addTag($node);
	}

    public function test_block_can_add_deivse_models()
    {
        $obj = new Block;
        $node = m::mock('Devise\Pages\Interpreter\Nodes\DeviseModelNode');
        $node->matched = ' data-devise="$model, Human name';
        $obj->addModel($node);
    }

    public function test_block_can_add_devise_model_creators()
    {
        $obj = new Block;
        $node = m::mock('Devise\Pages\Interpreter\Nodes\DeviseModelCreatorNode');
        $node->matched = ' data-devise-create-model="DvsUser"';
        $obj->addModelCreator($node);
    }

    public function test_block_can_get_devise_model_creators()
    {
        $obj = new Block;
        assertEquals([], $obj->getModelCreators());
    }

    public function test_block_can_get_devise_models()
    {
        $obj = new Block;
        assertEquals([], $obj->getModels());
    }

	public function test_block_can_add_children_blocks()
	{
        $obj = new Block;
        $block = m::mock('Devise\Pages\Interpreter\Block');
        $obj->addBlock($block);
	}

	public function test_block_can_get_starting_position()
	{
        $obj = new Block;
        $node = m::mock('Devise\Pages\Interpreter\Nodes\IfNode');
        $node->position = 42;
        $obj->start($node);
        assertEquals(42, $obj->getStartingPosition());
	}

	public function test_block_can_get_starting_block()
	{
        $obj = new Block;
        $node = m::mock('Devise\Pages\Interpreter\Nodes\IfNode');
        $obj->start($node);
        assertEquals($node, $obj->getStartBlock());
	}

    public function test_block_can_get_stopping_block()
    {
        $obj = new Block;
        $node = m::mock('Devise\Pages\Interpreter\Nodes\EndIfNode');
        $obj->stop($node);
        assertEquals($node, $obj->getStopBlock());
    }

	public function test_block_can_get_children_blocks()
	{
        $obj = new Block;
        $child = m::mock('Devise\Pages\Interpreter\Block');
        $obj->addBlock($child);
        assertEquals([$child], $obj->getBlocks());
	}

	public function test_block_can_get_tags()
	{
        $block1 = new Block;
        $block2 = new Block;
        $tag1 = m::mock('Devise\Pages\Interpreter\Nodes\DeviseTagNode');
        $tag2 = m::mock('Devise\Pages\Interpreter\Nodes\DeviseTagNode');
        $tag1->matched = ' data-devise="key1, image"';
        $tag2->matched = ' data-devise="key2, image"';
        $block1->addTag($tag1);
        $block2->addTag($tag2);
        $block1->addBlock($block2);
        $tags = $block1->getTags();
        assertCount(2, $tags);
    }
}