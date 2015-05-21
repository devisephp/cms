<?php namespace Devise\Languages;

class LocaleDetectorTest extends \DeviseTestCase
{
	public function setUp()
	{
		parent::setUp();

		$this->Framework = new \Devise\Support\Framework;
		$this->LocaleDetector = new LocaleDetector($this->Framework);
	}

	public function test_it_finds_current_locale()
	{
		assertEquals('en', $this->LocaleDetector->current());
	}

	public function test_it_finds_locale_from_cookie()
	{
		assertEquals(null, $this->LocaleDetector->cookie());
	}

	public function test_it_has_universal_locale()
	{
		assertEquals('en', $this->LocaleDetector->universal());
	}

	public function test_it_finds_locale_from_header()
	{
		assertEquals(substr(\Request::server('HTTP_ACCEPT_LANGUAGE', null), 0, 2), $this->LocaleDetector->header());
	}

	public function test_it_finds_locale_from_segment()
	{
		assertEquals(null, $this->LocaleDetector->segment());
	}

    public function test_it_updates_a_locale()
    {
    	$this->LocaleDetector->update('en');
    }

}