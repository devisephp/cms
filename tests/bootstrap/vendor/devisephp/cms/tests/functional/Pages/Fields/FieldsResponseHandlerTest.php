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
}