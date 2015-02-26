<?php namespace Devise\Pages\Interpreter;

class DeviseModelCreatorTest extends \DeviseTestCase
{
	public function setUp()
	{
		$node = new Nodes\DeviseModelCreatorNode(' data-devise-create-model="DvsUser, Human Name"', 19);
		$this->creator = new DeviseModelCreator($node);
	}

	public function test_it_can_be_created_from_node()
	{
		assertEquals('DvsUser', $this->creator->modelName);
		assertEquals('Human Name', $this->creator->humanName);
	}

	public function test_it_has_cid()
	{
		assertEquals('1f19f69d01a5a9324699717592892764bd5c95bd', $this->creator->cid());
	}

	public function test_it_can_replace_create_model_in_view()
	{
		assertContains(' data-dvs-cid-1f19f69d01a5a9324699717592892764bd5c95bd', $this->creator->replaceModelCreateTagInView($this->fixture('devise-views.view5')));
	}

	public function test_it_can_add_model_creator_in_view()
	{
		assertEquals('App::make(\'dvsPageData\')->addModelCreator("1f19f69d01a5a9324699717592892764bd5c95bd", "DvsUser", "Human Name");', $this->creator->addToDevisePageStr());
	}
}