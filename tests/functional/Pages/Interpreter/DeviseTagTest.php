<?php namespace Devise\Pages\Interpreter;

class DeviseTagTest extends \DeviseTestCase
{
	public function test_it_can_extract_out_unparsed_field_string()
	{
		$tag = new DeviseTag(' data-devise="key, type, human name, group, category, alternate, defaults"');
  		assertEquals("key", $tag->id);
  		assertEquals("field", $tag->bindingType);
  		assertEquals(null, $tag->collection);
  		assertEquals("key", $tag->key);
  		assertEquals("type", $tag->type);
  		assertEquals("human name", $tag->humanName);
  		assertEquals("group", $tag->group);
  		assertEquals("category", $tag->category);
  		assertEquals("alternate", $tag->alternateTarget);
  		assertEquals("defaults", $tag->defaults);
  		assertEquals(" data-devise=\"key, type, human name, group, category, alternate, defaults\"", $tag->value);
	}

	public function test_it_can_extract_out_unparsed_collection_string()
	{
		$tag = new DeviseTag(' data-devise="col[key], type, human name, collection name, group, category, alternate, defaults"');
  		assertEquals("col[key]", $tag->id);
  		assertEquals("collection", $tag->bindingType);
  		assertEquals("col", $tag->collection);
  		assertEquals("key", $tag->key);
  		assertEquals("type", $tag->type);
  		assertEquals("human name", $tag->humanName);
      assertEquals('collection name', $tag->collectionName);
  		assertEquals("group", $tag->group);
  		assertEquals("category", $tag->category);
  		assertEquals("alternate", $tag->alternateTarget);
  		assertEquals("defaults", $tag->defaults);
  		assertEquals(" data-devise=\"col[key], type, human name, collection name, group, category, alternate, defaults\"", $tag->value);
	}

	public function test_it_can_extract_out_unparsed_variable_string()
	{
		$tag = new DeviseTag(' data-devise="$model, human name, group"');
  		assertEquals('$model', $tag->id);
  		assertEquals("variable", $tag->bindingType);
  		assertEquals(null, $tag->collection);
      assertEquals('$model', $tag->key);
  		assertEquals('[\'$model\' => $model,]', $tag->chain);
  		assertEquals("variable", $tag->type);
  		assertEquals("human name", $tag->humanName);
  		assertEquals("group", $tag->group);
  		assertEquals(null, $tag->category);
  		assertEquals(null, $tag->alternateTarget);
  		assertEquals(null, $tag->defaults);
  		assertEquals(' data-devise="$model, human name, group"', $tag->value);
	}

	public function test_it_can_extract_out_parsed_string()
	{
		$tag = new DeviseTag("data-devise-<?php echo devise_tag_cid('key', 'field', null, 'key', 'type', 'human name', 'collection name', 'group', 'category', 'alternate', defaults) ?>");
  		assertEquals("key", $tag->id);
  		assertEquals("field", $tag->bindingType);
  		assertEquals(null, $tag->collection);
  		assertEquals("key", $tag->key);
  		assertEquals("type", $tag->type);
  		assertEquals("human name", $tag->humanName);
      assertEquals("collection name", $tag->collectionName);
  		assertEquals("group", $tag->group);
  		assertEquals("category", $tag->category);
  		assertEquals("alternate", $tag->alternateTarget);
  		assertEquals("defaults", $tag->defaults);
  		assertEquals("data-devise-<?php echo devise_tag_cid('key', 'field', null, 'key', 'type', 'human name', 'collection name', 'group', 'category', 'alternate', defaults) ?>", $tag->value);
	}

	public function test_it_uses_value_for_string()
	{
		$tag = new DeviseTag(' data-devise="key, type, human name, group, category, alternate, defaults"');
		assertEquals(' data-devise="key, type, human name, group, category, alternate, defaults"', $tag->__toString());
	}
}