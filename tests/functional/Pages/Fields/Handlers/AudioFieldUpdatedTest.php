<?php namespace Devise\Pages\Fields\Handlers;

use Mockery as m;
use Devise\Pages\Fields\FieldValue;

class AudioFieldUpdatedTest extends \DeviseTestCase
{
	public function test_it_handles_updates()
	{
		$FieldValue = new FieldValue('{}');
		$MediaPathHelper = m::mock('Devise\Media\MediaPaths');
		$DvsField = m::mock('DvsField');
		$DvsField->shouldReceive('getAttribute')->with('values')->andReturn($FieldValue);
		$DvsField->shouldReceive('setAttribute')->with('json_value', $FieldValue->toJSON());
		$DvsField->shouldReceive('save')->times(1);
        $Encoder = m::mock('Devise\Media\Encoding\ZencoderJob');
        $Framework = new \Devise\Support\Framework;
        $AudioFieldUpdated = new AudioFieldUpdated($MediaPathHelper, $Encoder, $Framework);

		$AudioFieldUpdated->handle($DvsField, []);
	}
}