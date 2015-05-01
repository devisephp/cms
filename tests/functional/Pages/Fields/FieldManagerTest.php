<?php namespace Devise\Pages\Fields;

use Mockery as m;

class FieldManagerTest extends \DeviseTestCase
{
	public function setUp()
	{
		$this->FieldsRepository = new FieldsRepository(new \DvsField, new \DvsGlobalField);
        $this->Framework = new \Devise\Support\Framework;
		$this->FieldManager = new FieldManager(new \DvsField, new \DvsGlobalField, $this->FieldsRepository, $this->Framework);
	}

	public function test_it_marks_content_requested()
	{
		$fieldIds = [1];
		$this->FieldManager->markNoContentRequested($fieldIds);
		$field = (new \DvsField)->find(1);
		assertEquals(0, $field->content_requested);
	}

	public function test_it_resets_field()
	{
		$this->FieldManager->resetField(1, 'field');
	}

	public function test_it_updates_field()
	{
		$field = $this->FieldManager->updateField(1, ['field' => ['content_requested' => 1, 'values' => ['key1' => 'value']], 'page' => ['page_version_id' => 42]]);
		assertEquals('value', $field->values->key1);
	}

	public function test_it_calls_events_on_update()
	{
		$this->FieldManager->Event = m::mock('EventManagerThing');
		$this->FieldManager->Event->shouldReceive('fire')->twice();
		$field = $this->FieldManager->updateField(1, ['field' => ['content_requested' => 1, 'values' => ['key1' => 'value']], 'page' => ['page_version_id' => 42]]);
	}
}
