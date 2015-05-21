<?php namespace Devise\Languages;

use Mockery as m;

class LanguageDetectorTest extends \DeviseTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->Framework = new \Devise\Support\Framework;
		$this->LanguageDetector = new LanguageDetector(new LocaleDetector($this->Framework), new \DvsLanguage);
	}

	public function test_it_can_detect_current_language()
	{
		$language = $this->LanguageDetector->current();
		assertEquals('en', $language->code);
	}

	public function test_it_can_detect_universal_language()
	{
		$language = $this->LanguageDetector->universal();
		assertEquals('en', $language->code);
	}

	public function test_it_can_update_language()
	{
		$LocaleDetector = m::mock('Devise\Languages\LocaleDetector');
        $LocaleDetector->shouldReceive('update')->times(1);

		$LanguageDetector = new LanguageDetector($LocaleDetector, new \DvsLanguage);
		$LanguageDetector->update(new \DvsLanguage);
	}

    public function test_it_can_give_me_primary_language_id()
    {
        $Config = m::mock('Illuminate\Config\Repository');
        $Config->shouldReceive('get')->times(1)->andReturn(45);
        $LanguageDetector = new LanguageDetector(new LocaleDetector($this->Framework), new \DvsLanguage, $Config);
        assertEquals(45, $LanguageDetector->primaryLanguageId());
    }
}