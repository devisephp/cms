<?php namespace Devise\Pages\Fields;

use Mockery as m;

class FieldsResponseHandlerTest extends \DeviseTestCase
{
	public function test_it_handles_update_requests()
	{
		$FieldManager = m::mock('Devise\Pages\Fields\FieldManager');
		$FieldManager->shouldReceive('updateField')->times(1)->andReturn([]);
		$FieldsResponseHandler = new FieldsResponseHandler($FieldManager);
		$FieldsResponseHandler->requestUpdate(1, []);
	}

	public function test_it_handles_reset_requests()
	{
		$FieldManager = m::mock('Devise\Pages\Fields\FieldManager');
		$FieldManager->shouldReceive('resetField')->times(1)->with(42, 'field')->andReturn([]);
		$FieldsResponseHandler = new FieldsResponseHandler($FieldManager);
		$FieldsResponseHandler->requestReset(42, 'field');
	}
}