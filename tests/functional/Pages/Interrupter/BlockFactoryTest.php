<?php namespace Devise\Pages\Interrupter;

class BlockFactoryTest extends \DeviseTestCase
{
	public function setUp()
	{
		parent::setUp();

		\View::addNamespace('devise-views', __DIR__ . '/../../../fixtures/devise-views');
		$this->factory = new BlockFactory(new ViewOpener);
	}

	public function test_it_can_create_a_new_block_from_view1()
	{
		$block = $this->factory->createBlock($this->fixture('devise-views.view1'));

		assertEquals(5, count($block->getTags()));
		assertEquals(4, count($block->getBlocks()));
		assertEquals(0, count($block->getModels()));
	}

	public function test_it_can_create_a_new_block_with_model_in_it()
	{
		//
		// we are adding the ability to have models in a devise tag
		// to do this we use data-devise="$somevar" and then we need
		// to transform this code into the ability to edit this Eloquent
		// model
		//
		$block = $this->factory->createBlock($this->fixture('devise-views.view4'));

		assertEquals(0, count($block->getTags()));
		assertEquals(1, count($block->getBlocks()));
		assertEquals(1, count($block->getModels()));
	}

	public function test_it_can_create_a_new_model_creator_block()
	{
		$block = $this->factory->createBlock($this->fixture('devise-views.view5'));

		assertEquals(0, count($block->getTags()));
		assertEquals(0, count($block->getBlocks()));
		assertEquals(1, count($block->getModelCreators()));
	}

	public function test_it_can_handle_recursion_in_view3()
	{
		$block = $this->factory->createBlock($this->fixture('devise-views.view3'));

		// just making it to this point, means we have not gotten caught up
		// in an infinite recursion loop because view3 requires itself
		// and keeps requiring itself over and over without the fixes
		// we've put into place.
		//
		// but let's go ahead and check that our tree level is correct
		// for instance, we want to make sure includedViews are not being
		// polluted (since we are using memory references in the ViewOpener)
		// and we also want to make sure that the second time around including
		// the view3 that it is not included again, even though that is kind of
		// given because we actually made it here without a segfault error

		$blocks = $block->getBlocks();

		// top level @if and @if in view3
		assertEquals(array(), $blocks[0]->includedViews);
		assertEquals(array(), $blocks[1]->includedViews);

		// @if @foreach
		$blocks = $blocks[0]->getBlocks();
		assertEquals(array(), $blocks[0]->includedViews);

		// @if @foreach @include
		$blocks = $blocks[0]->getBlocks();
		assertEquals(array('devise-views::view3'), $blocks[0]->includedViews);

		// @if @foreach @include @if
		$blocks = $blocks[0]->getBlocks();
		assertEquals(array('devise-views::view3'), $blocks[0]->includedViews);

		// @if @foreach @include @if
		$blocks = $blocks[0]->getBlocks();
		assertEquals(array('devise-views::view3'), $blocks[0]->includedViews);

		// @if @foreach @include @if @foreach
		$blocks = $blocks[0]->getBlocks();
		assertEquals(array('devise-views::view3'), $blocks[0]->includedViews);

		// @if @foreach @include @if @foreach @include
		assertCount(0, $blocks[0]->getBlocks());
	}

}