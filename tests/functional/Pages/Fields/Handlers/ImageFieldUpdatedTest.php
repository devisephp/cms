<?php namespace Devise\Pages\Fields\Handlers;

use Mockery as m;
use Devise\Pages\Fields\FieldValue;

class ImageFieldUpdatedTest extends \DeviseTestCase
{
	public function test_it_handles_empty_image_updates()
	{
		$Images = m::mock('Devise\Media\Images\Images');
		$MediaPathHelper = m::mock('Devise\Media\MediaPaths');
		$Framework = m::mock('Devise\Support\Framework');
		$Caption = m::mock('Devise\Media\Helpers\Caption');
		$DvsField = m::mock('DvsField');
		$FieldValue = new FieldValue('{}');

		$MediaPathHelper->shouldReceive('basePath')->times(1)->andReturn('/');
		$DvsField->shouldReceive('getAttribute')->with('values')->andReturn($FieldValue);
		$DvsField->shouldReceive('setAttribute')->with('json_value', $FieldValue->toJSON());
		$DvsField->shouldReceive('save')->times(1);

		$ImageFieldUpdated = new ImageFieldUpdated($Images, $MediaPathHelper, $Caption, $Framework);
		$ImageFieldUpdated->handle($DvsField, [], $DvsField);
	}

	public function test_it_handles_provided_image_update()
	{
		$Images = m::mock('Devise\Media\Images\Images');
		$MediaPathHelper = m::mock('Devise\Media\MediaPaths');
		$Framework = m::mock('Devise\Support\Framework');
		$Caption = m::mock('Devise\Media\Helpers\Caption');
		$DvsField = m::mock('DvsField');
		$FieldValue = new FieldValue('{"image" : "/some/path/to/file.jpg"}');

		$MediaPathHelper->shouldReceive('basePath')->times(1)->andReturn('/');
		$MediaPathHelper->shouldReceive('isUrlPath')->andReturn(true);
		$DvsField->shouldReceive('getAttribute')->with('values')->andReturn($FieldValue);
		$DvsField->shouldReceive('setAttribute');
		$DvsField->shouldReceive('save')->times(1);

		$ImageFieldUpdated = new ImageFieldUpdated($Images, $MediaPathHelper, $Caption, $Framework);
		$ImageFieldUpdated->handle($DvsField, [], $DvsField);

		assertEquals('/some/path/to/file.jpg', $FieldValue->image_url);
	}
}