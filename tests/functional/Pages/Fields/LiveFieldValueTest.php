<?php namespace Devise\Pages\Fields;

use Mockery as m;

class LiveFieldValueTest extends \DeviseTestCase
{
	public function test_it_can_be_cast_to_string()
	{
		$obj = new LiveFieldValue('{}', 12, 'field');
		assertEquals('', $obj->__toString());
	}

	public function test_it_handles_chaining_invalid_keys()
	{
		$obj = new LiveFieldValue('{}', 12, 'field');
		assertEquals('', $obj->noexception->here);
	}

	public function test_it_can_be_cast_to_json()
	{
		$obj = new LiveFieldValue('{}', 12, 'field');
		assertEquals('{}', $obj->toJSON());
	}

	public function test_it_can_fetch_valid_keys()
	{
		$obj = new LiveFieldValue('{"key1" : "value1"}', 12, 'field');
		assertEquals('value1', $obj->key1);
	}

	public function test_it_can_use_defaults_for_blank_key()
	{
		$obj = new LiveFieldValue('{}', 12, 'field');
		assertEquals('value2', $obj->key1('value2'));
	}

	public function test_it_can_overrides()
	{
		$obj = new LiveFieldValue('{"zero": ""}', 12, 'field');
		$obj->override(['one' => 'two', 'buckle' => 'my shoe']);
		assertEquals('{"one":"two","buckle":"my shoe"}', $obj->toJSON());
	}

	public function test_it_merges_data()
	{
		$obj = new LiveFieldValue('{}', 12, 'field');
		$obj->merge(['one' => 'two', 'buckle' => 'my shoe']);
		assertEquals('{"one":"two","buckle":"my shoe"}', $obj->toJSON());
	}

	public function test_it_has_id()
	{
		$obj = new LiveFieldValue('{}', 12, 'field');
		assertEquals(12, $obj->__id());
	}

	public function test_it_has_type()
	{
		$obj = new LiveFieldValue('{}', 12, 'field');
		assertEquals('field', $obj->__type());
	}

	public function test_it_extracts()
	{
		$obj = new LiveFieldValue('{}', 12, 'field');
		$obj->extract();
	}

	public function test_it_unextracts()
	{
		$obj = new LiveFieldValue('{}', 12, 'field');
		$obj->unextract();
	}
}