<?php namespace Devise\Pages\Models;

class ModelFieldValidationFailedExceptionTest extends \DeviseTestCase
{
	public function test_it_works()
	{
		$message = 'Message';
		$errors = new \Illuminate\Support\MessageBag;
		$exception = new ModelFieldValidationFailedException($message, $errors);
		assertEquals($message, $exception->getMessage());
		assertEquals($errors, $exception->getErrors());
	}
}