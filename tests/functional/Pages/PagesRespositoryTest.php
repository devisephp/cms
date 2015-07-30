<?php namespace Devise\Pages;

use Mockery as m;

class PagesRepositoryTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->DvsPage = new \DvsPage;
        $this->DvsField = new \DvsField;
        $this->DvsGlobalField = new \DvsGlobalField;
        $this->LanguageDetector = m::mock('Devise\Languages\LanguageDetector');
        $this->CollectionsRepository = m::mock('Devise\Pages\Collections\CollectionsRepository');
        $this->Input = m::mock('Illuminate\Http\Request');
        $this->Config = m::mock('Illuminate\Config\Repository');
        $this->URL = m::mock('Illuminate\Routing\UrlGenerator');
        $this->File = m::mock('Illuminate\Filesystem\Filesystem');
        $this->ViewOpener = m::mock('Devise\Pages\Interpreter\ViewOpener');
        $this->PagesRepository = new PagesRepository($this->DvsPage, $this->DvsField, $this->DvsGlobalField, $this->LanguageDetector, $this->CollectionsRepository, $this->Input, $this->Config, $this->URL, $this->File, $this->ViewOpener);
    }

    public function test_it_finds_page()
    {
        $DvsLanguage = \DvsLanguage::find(45);
        $this->LanguageDetector->shouldReceive('current')->andReturn($DvsLanguage);
        $this->CollectionsRepository->shouldReceive('findCollectionsForPageVersion')->andReturn([]);
        $page = $this->PagesRepository->find(1);
        assertEquals(1, $page->id);
    }

    public function test_it_finds_page_by_route_name()
    {
        $DvsLanguage = \DvsLanguage::find(45);
        $this->LanguageDetector->shouldReceive('current')->andReturn($DvsLanguage);
        $this->CollectionsRepository->shouldReceive('findCollectionsForPageVersion')->andReturn([]);
        $page = $this->PagesRepository->findByRouteName('dvs-pages');
        assertEquals(1, $page->id);
    }

    public function test_it_finds_localized_page()
    {
        // create a translated spanish page of page #1
        $this->createTestPage([
            'translated_from_page_id' => '1',
            'language_id'             => '162', // spanish page
            'route_name'              => 'dvs-pages-es',
            'slug'                    => '/admin/es/pages',
        ]);

        $CurrentLanguage = \DvsLanguage::find(162);
        $this->LanguageDetector->shouldReceive('current')->andReturn($CurrentLanguage);
        $EnglishPage = \DvsPage::find(1);
        $SpanishPage = $this->PagesRepository->findLocalizedPage($EnglishPage);
        assertEquals(99999, $SpanishPage->id);
    }

    public function test_it_finds_pages()
    {
        $pageCount = \DB::table('dvs_pages')->where('dvs_admin', '<>', 1)->count();
        $this->createTestPage([]);
        $this->Config->shouldReceive('get')->times(1)->andReturn(45);
        $this->Input->shouldReceive('get')->with('language_id', 45)->andReturn(45);
        $this->Input->shouldReceive('get')->with('show_admin', false)->andReturn(true);
        $this->URL->shouldReceive('route')->andReturn('http://boyf.me');
        $pages = $this->PagesRepository->pages();
        assertCount($pageCount + 1, $pages);
    }

    public function test_it_gets_available_languagse_for_page()
    {
        $this->URL->shouldReceive('route')->andReturn('http://boyf.me');
        $languages = $this->PagesRepository->availableLanguagesForPage(1);
        assertCount(1, $languages);
    }

    public function test_it_gets_page_versions_for_page_id()
    {
        $pageVersions = $this->PagesRepository->getPageVersions(1, $selectedVersionId = 1);
        assertCount(1, $pageVersions);
        assertEquals('selected', $pageVersions[0]->selected);
    }

    public function test_it_gets_route_list()
    {
        $this->createTestPage([]);
        $this->Config->shouldReceive('get')->times(1)->andReturn(45);
        $list = $this->PagesRepository->getRouteList();
        assertContains(' Test', array_keys($list));
    }

    public function test_it_gets_live_page_version()
    {
        $page = \DvsPage::find(1);
        $version = $this->PagesRepository->getLivePageVersion($page);
        assertEquals(1, $version->id);
    }

    public function test_it_gets_live_page_version_by_date()
    {
        $page = \DvsPage::find(1);
        $version = $this->PagesRepository->getLivePageVersionByDate($page);
        assertEquals(1, $version->id);
    }

    public function test_it_gets_live_page_version_by_id()
    {
        $page = \DvsPage::find(1);
        $version = $this->PagesRepository->getLivePageVersionById($page, 1);
        assertEquals(1, $version->id);
    }

    public function test_it_does_not_get_live_page_version_by_cookie_when_not_set()
    {
        $page = \DvsPage::find(1);
        $version = $this->PagesRepository->getLivePageVersionByCookie($page);
        assertNull($version);
    }

    public function test_it_gets_live_page_version_by_cookie_when_cookie_is_set()
    {
        $page = \DvsPage::find(1);
        $this->PagesRepository->Request = m::mock('RequestMock');
        $this->PagesRepository->Request->shouldReceive('cookie')->andReturn(1);
        $version = $this->PagesRepository->getLivePageVersionByCookie($page);
        assertEquals(1, $version->id);
    }

    public function test_it_gets_live_page_version_by_ab()
    {
        $page = \DvsPage::find(1);
        $version = $this->PagesRepository->getLivePageVersionByAB($page);
        assertEquals(1, $version->id);
    }

    public function test_it_gets_live_page_version_by_dice_roll()
    {
        $page = \DvsPage::find(1);
        $defaultVersion = \DvsPageVersion::find(1);
        $defaultVersion->ab_testing_amount = 50;
        $defaultVersion->save();
        $version = $this->PagesRepository->getLivePageVersionByDiceRoll($page);
        assertEquals(1, $version->id);
    }

    public function test_it_gets_page_versions_by_ab()
    {
        $page = \DvsPage::find(1);
        $version = \DvsPageVersion::find(1);
        $version->ab_testing_amount = 50;
        $version->save();
        $newVersion = \DvsPageVersion::create([
            'page_id' => 1,
            'created_by_user_id' => 1,
            'name' => 'New Version',
            'starts_at' => new \DateTime('yesterday'),
            'ends_at' => null,
            'ab_testing_amount' => 50
        ]);
        $versions = $this->PagesRepository->getPageVersionsByAB($page);
        assertCount(2, $versions);
    }

    public function test_it_gets_page_version_by_name()
    {
        $page = \DvsPage::find(1);
        $version = $this->PagesRepository->getPageVersionByName($page, 'Default');
        assertEquals(1, $version->id);
    }

    public function test_it_gets_pages_list()
    {
        $expectedSize = \DB::table('dvs_pages')->count();
        $list = $this->PagesRepository->getPagesList($includeAdmin = true);
        assertCount($expectedSize, $list);
    }

    public function test_it_finds_page_templates()
    {
        $realConfig = \Config::get('devise.templates');
        $page = \DvsPage::find(1);
        $this->Config->shouldReceive('get')->once()->andReturn($realConfig);
        $this->ViewOpener->shouldReceive('findAllIncludedViews')->once()->with('devise::admin.pages.index')->andReturn(['awesome.view']);
        $templates = $this->PagesRepository->findPageTemplates($page);
        assertEquals(['devise::admin.pages.index', 'devise::admin.layouts.master', 'awesome.view'], $templates);
    }

    public function test_it_finds_template_variables()
    {
        $templates = ['devise::admin.pages.index'];
        $realConfig = \Config::get('devise.templates');
        $page = \DvsPage::find(1);
        $this->Config->shouldReceive('get')->once()->andReturn($realConfig);
        $vars = $this->PagesRepository->findTemplateVariables($templates);
        assertEquals(['languages', 'pages', 'templateList'], $vars);
    }

    /**
     * Helper function to create test pages in database
     *
     * @param $input
     */
    protected function createTestPage($input)
    {
        $input = array_merge([
            'id'                      => '99999',
            'language_id'             => '45',
            'view'                    => 'some.view',
            'title'                   => 'Some test title',
            'http_verb'               => 'get',
            'route_name'              => 'dvs-test-route-name',
            'is_admin'                => '0',
            'dvs_admin'               => '0',
            'slug'                    => '/test/pages',
            'short_description'       => 'A short description',
        ], $input);

        // create a non-dvsadmin page
        \DB::table('dvs_pages')->insert($input);
    }
}
