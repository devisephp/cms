<?php namespace Devise\Pages\Models;

use Mockery as m;

class ModelsResponseHandlerTest extends \DeviseTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->ModelManager = m::mock('Devise\Pages\Models\ModelManager');
		$this->Framework = new \Devise\Support\Framework;
		$this->Framework->Response = m::mock('MockedResponse');
		$this->ModelsResponseHandler = new ModelsResponseHandler($this->ModelManager, $this->Framework);
	}

	public function test_execute_update_model_field()
	{
		$this->ModelManager->shouldReceive('updateField')->with([], [])->once()->andReturn('data');
		$outcome = $this->ModelsResponseHandler->executeModelFieldUpdate(1, ['field' => [], 'page' => []]);
		assertEquals(['field' => 'data'], $outcome);
	}

	public function test_execute_update_model_fields()
	{
		$this->ModelManager->shouldReceive('updateFields')->with([], [])->once()->andReturn('data');
		$outcome = $this->ModelsResponseHandler->executeModelFieldsUpdate(['fields' => [], 'page' => []]);
		assertEquals(['fields' => 'data'], $outcome);
	}

	public function test_execute_create_model_fields()
	{
		$this->ModelManager->shouldReceive('createFieldsAndModel')->with([], [])->once()->andReturn(['data1', 'data2']);
		$outcome = $this->ModelsResponseHandler->executeModelFieldsCreate(['fields' => [], 'page' => []]);
		assertEquals(['model' => 'data2', 'fields' => 'data1'], $outcome);
	}

	public function test_execute_update_model_field_with_error()
	{
		$exception = m::mock('Devise\Pages\Models\ModelFieldValidationFailedException');
		$exception->shouldReceive('getErrors')->andReturn('errors');
		$this->Framework->Response->shouldReceive('json')->with(['errors' => 'errors'], 403)->andReturn('response');
		$this->ModelManager->shouldReceive('updateField')->with([], [])->once()->andThrow($exception);
		$outcome = $this->ModelsResponseHandler->executeModelFieldUpdate(1, ['field' => [], 'page' => []]);
		assertEquals('response', $outcome);
	}

	public function test_execute_update_model_fields_with_error()
	{
		$exception = m::mock('Devise\Pages\Models\ModelFieldValidationFailedException');
		$exception->shouldReceive('getErrors')->andReturn('errors');
		$this->Framework->Response->shouldReceive('json')->with(['errors' => 'errors'], 403)->andReturn('response');
		$this->ModelManager->shouldReceive('updateFields')->with([], [])->once()->andThrow($exception);
		$outcome = $this->ModelsResponseHandler->executeModelFieldsUpdate(['fields' => [], 'page' => []]);
		assertEquals('response', $outcome);
	}

	public function test_execute_create_model_fields_with_error()
	{
		$exception = m::mock('Devise\Pages\Models\ModelFieldValidationFailedException');
		$exception->shouldReceive('getErrors')->andReturn('errors');
		$this->Framework->Response->shouldReceive('json')->with(['errors' => 'errors'], 403)->andReturn('response');
		$this->ModelManager->shouldReceive('createFieldsAndModel')->with([], [])->once()->andThrow($exception);
		$outcome = $this->ModelsResponseHandler->executeModelFieldsCreate(['fields' => [], 'page' => []]);
		assertEquals('response', $outcome);
	}
}