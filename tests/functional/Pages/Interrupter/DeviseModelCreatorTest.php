<?php namespace Devise\Pages\Interrupter;

class DeviseModelCreatorTest extends \DeviseTestCase
{
	public function test_it_can_be_created_from_node()
	{
		$node = new Nodes\DeviseModelCreatorNode(' data-devise-create-model="DvsUser, some human name here"', 19);
		$creator = new DeviseModelCreator($node);

		assertEquals('DvsUser', $creator->modelName);
		assertEquals('some human name here', $creator->humanName);
	}

	public function test_it_has_cid()
	{
		$this->markTestIncomplete();
	}

	public function test_it_can_replace_create_model_in_view()
	{
		$this->markTestIncomplete();
	}

	public function test_it_can_add_model_creator_in_view()
	{
		$this->markTestIncomplete();
	}
}