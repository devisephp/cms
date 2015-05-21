<?php namespace Devise\Pages\Fields;

use Mockery as m;

class FieldValueTest extends \DeviseTestCase
{
	public function test_it_can_be_cast_to_string()
	{
		$obj = new FieldValue('{}');
		assertEquals('', $obj->__toString());
	}

	public function test_it_handles_chaining_invalid_keys()
	{
		$obj = new FieldValue('{}');
		assertEquals('', $obj->noexception->here);
	}

	public function test_it_can_be_cast_to_json()
	{
		$obj = new FieldValue('{}');
		assertEquals('{}', $obj->toJSON());
	}

	public function test_it_can_fetch_valid_keys()
	{
		$obj = new FieldValue('{"key1" : "value1"}');
		assertEquals('value1', $obj->key1);
	}

	public function test_it_can_use_defaults_for_blank_key()
	{
		$obj = new FieldValue('{}');
		assertEquals('value2', $obj->key1('value2'));
	}

	public function test_it_merges_data()
	{
		$obj = new FieldValue('{}');

		$obj->merge(['one' => 'two', 'buckle' => 'my shoe']);

		assertEquals('{"one":"two","buckle":"my shoe"}', $obj->toJSON());
	}
}