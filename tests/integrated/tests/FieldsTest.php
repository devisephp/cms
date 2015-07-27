<?php

class FieldsTest extends Integrated
{
	public function test_it_can_edit_the_page_version_model()
	{
		$text = str_random(32);
		$this->sidebar('model0-node')
			 ->mousedown('[data-model-field-id]')
			 ->clear('[name=text]')
			 ->fill($text, 'text')
			 ->mousedown('.dvs-sidebar-save-group')
			 ->wait()
			 ->seeInDatabase('dvs_model_fields', ['json_value' => '{"text":"'.$text.'"}']);
	}

}