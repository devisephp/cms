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

	public function test_it_updates_a_field()
	{
		$this->markTestIncomplete();
		// $this->FieldManager->updateField($fieldId, $input)
	}

	public function test_it_marks_content_requested()
	{
		$this->markTestIncomplete();
		// $this->FieldManager->markNoContentRequested($fieldIds)
	}

	// /**
	//  * @expectedException Devise\Support\DeviseValidationException
	//  */
	// public function test_it_handles_validation_when_creating_new_field()
	// {
	// 	$this->FieldManager->findOrCreateField([]);
	// }

	// public function test_it_creates_new_field_from_input_data()
	// {
	// 	// given no field exists for this input data
	// 	$previous = \DvsField::count();

	// 	$this->LanguagesRepository->shouldReceive('findLanguageForPageVersion')
	// 		->times(1)
	// 		->andReturn(\DvsLanguage::find(45));


	// 	// when we call this method with input data
	// 	$output = $this->FieldManager->findOrCreateField([
	// 		'human_name' => 'Human Name',
	// 		'key' => 'key42',
	// 		'type' => 'text',
	// 		'settings' => '{}',
	// 		'page_version_id' => '1',
	// 		'value' => '{}',
	// 	]);

	// 	// then it should create a new field from input data
	// 	assertEquals('key42', $output->key);
	// 	assertEquals($previous + 1, \DvsField::count());
	// }

	// public function test_it_finds_existing_field_from_input_data()
	// {
	// 	$previous = \DvsField::count();

	// 	$output = $this->FieldManager->findOrCreateField([
	// 		'human_name' => 'Good-Bye',
	// 		'key' => 'goodbye',
	// 		'type' => 'text',
	// 		'settings' => '{}',
	// 		'page_version_id' => '1',
	// 		'value' => '{}',
	// 	]);

	// 	assertEquals('goodbye', $output->key);
	// 	assertEquals($previous, \DvsField::count());
	// }

	// public function test_it_updates_field()
	// {
	// 	$field = $this->FieldManager->updateField(1, ['key1' => 'value']);

	// 	assertEquals('value', $field->values->key1);
	// }
}
