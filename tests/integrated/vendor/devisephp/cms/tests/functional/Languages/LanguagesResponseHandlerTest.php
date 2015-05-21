<?php namespace Devise\Languages;

use Mockery as m;

class LanguagesResponseHandlerTest extends \DeviseTestCase
{
	public function test_it_can_patch_a_language()
	{
		$Manager = m::mock('Devise\Languages\LanguagesManager');
		$Manager->shouldReceive('modifyActiveFlag')->times(1);
		$LanguagesResponseHandler = new LanguagesResponseHandler(\App::make('Illuminate\Routing\Redirector'), $Manager);

		$LanguagesResponseHandler->requestPatchLanguage(1, array('active' => true));
	}
}