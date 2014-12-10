<?php namespace Devise\Languages;

class LanguagesManagerTest extends \DeviseTestCase
{
	public function test_it_can_activate_a_language()
	{
		$LanguageManager = new LanguagesManager(new \DvsLanguage);
		$LanguageManager->modifyActiveFlag($id = 31, $isActive = true);

		// the active flag should be true now...
		assertEquals(true, \DvsLanguage::find(31)->active);
	}
}