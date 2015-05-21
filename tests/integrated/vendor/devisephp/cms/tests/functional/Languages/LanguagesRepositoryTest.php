<?php namespace Devise\Languages;

use Mockery as m;

class LanguagesRepositoryTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->LanguageDetector = m::mock('Devise\Languages\LanguageDetector');
        $this->LanguagesRepository = new LanguagesRepository(new \DvsLanguage, $this->LanguageDetector, new \DvsPage, new \DvsPageVersion);
    }

	public function test_it_can_get_paginated_list_of_languages()
	{
        $output = $this->LanguagesRepository->languages();

        assertCount(201, $output);
	}

	public function test_it_can_get_a_list_of_active_languages()
	{
        $output = $this->LanguagesRepository->activeLanguageList();

        assertEquals($output, array(45 => 'English'));
	}

	public function test_it_can_get_a_list_of_languages_available_for_specific_page()
	{
        $page = \DvsPage::find(1);
        $output = $this->LanguagesRepository->languageSelectorOptions($page);

        assertEquals($output, array('/admin/pages' => 'English'));
	}

	public function test_it_can_get_current_langauge()
	{
        $LanguageDetector = m::mock('Devise\Languages\LanguageDetector');
        $LanguageDetector->shouldReceive('current')->times(1);
        $LanguagesRepository = new LanguagesRepository(new \DvsLanguage, $LanguageDetector, new \DvsPage, new \DvsPageVersion);
        $LanguagesRepository->currentLanguage();
	}

	public function test_it_can_find_language_for_specific_page_version()
	{
        // given this page version
        \DB::table('dvs_page_versions')->insert([
            'page_id' => 1,
            'created_by_user_id' => 1,
            'name' => 'Default',
        ]);

        // when you call this
        $language = $this->LanguagesRepository->findLanguageForPageVersion(1);

        // then...
        assertEquals('en', $language->code);
	}
}