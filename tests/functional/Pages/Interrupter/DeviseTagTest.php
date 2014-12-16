<?php namespace Devise\Pages\Interrupter;

class DeviseTagTest extends \DeviseTestCase
{
	protected function tag($deviseTag, $position = 0)
	{
		$node = new Nodes\DeviseTagNode($deviseTag, $position);
		return new DeviseTag($node);
	}

	public function test_it_can_be_created_from_node()
	{
		$tag = $this->tag(' data-devise="keyname1, type, humanName, group, category, target"', 19);

		assertEquals('keyname1', $tag->key);
		assertEquals('type', $tag->type);
		assertEquals('humanName', $tag->humanName);
		assertEquals('group', $tag->group);
		assertEquals('category', $tag->category);
		assertEquals('target', $tag->alternateTarget);
	}

	/**
	 * @expectedException Devise\Pages\Interrupter\Exceptions\InvalidDeviseKeyException
	 */
	public function test_it_will_not_allow_invalid_keys1()
	{
		$tag = $this->tag(' data-devise="invalid-keyname-1, type"', 19);
	}

	/**
	 * @expectedException Devise\Pages\Interrupter\Exceptions\InvalidDeviseKeyException
	 */
	public function test_it_will_not_allow_invalid_keys2()
	{
		$tag = $this->tag(' data-devise="col[], type"', 19);
	}

	/**
	 * @expectedException Devise\Pages\Interrupter\Exceptions\InvalidDeviseKeyException
	 */
	public function test_it_will_not_allow_invalid_keys3()
	{
		$tag = $this->tag(' data-devise="col[#invalid], type"', 19);
	}

	/**
	 * @expectedException Devise\Pages\Interrupter\Exceptions\InvalidDeviseTagException
	 */
	public function test_it_checks_for_key_and_type_existence()
	{
		$tag = $this->tag(' data-devise=""', 19);
	}

	public function test_it_can_create_human_name_from_key_name()
	{
		$tag = $this->tag(' data-devise="keyname1, type"', 19);

		assertEquals('Keyname1', $tag->humanName);
	}

	public function test_it_can_tell_the_difference_between_binding_and_collection()
	{
		$tag1 = $this->tag(' data-devise="keyname1, type"', 19);
		$tag2 = $this->tag(' data-devise="col[keyname1], type"', 19);

		assertEquals('Binding', $tag1->tagBindingType());
		assertEquals('Collection', $tag2->tagBindingType());
	}

	public function test_it_can_return_hidden_placeholder_string()
	{
		$tag1 = $this->tag(' data-devise="keyname1, type"', 19);
		$tag2 = $this->tag(' data-devise="col[keyname1], type"', 19);

		assertContains('<span style="display:none;" data-dvs-placeholder-keyname1-id="keyname1"></span>', $tag1->hiddenPlaceholderStr());
		assertContains('<span style="display:none;" data-dvs-placeholder-col-keyname1-id="keyname1"></span>', $tag2->hiddenPlaceholderStr());
	}

	public function test_it_can_return_add_to_devise_page_string()
	{
		$tag1 = $this->tag(' data-devise="keyname1, type"', 19);
		$tag2 = $this->tag(' data-devise="col[keyname1], type"', 19);

		assertEquals("App::make('dvsPageData')->addBinding('keyname1', 'type', 'Keyname1', null, null, null);" . PHP_EOL, $tag1->addToDevisePageStr());
		assertEquals("App::make('dvsPageData')->addCollection('col', 'keyname1', 'type', 'Keyname1', null, null, null);" . PHP_EOL, $tag2->addToDevisePageStr());
	}
}