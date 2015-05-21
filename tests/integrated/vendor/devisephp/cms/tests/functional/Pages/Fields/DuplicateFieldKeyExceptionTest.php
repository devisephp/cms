<?php namespace Devise\Pages\Fields;

class DuplicateFieldKeyExceptionTest extends \DeviseTestCase
{
	public function test_it_constructs()
	{
		new DuplicateFieldKeyException;
	}
}