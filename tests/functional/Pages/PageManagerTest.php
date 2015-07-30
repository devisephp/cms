<?php namespace Devise\Pages;

use Mockery as m;

class PageManagerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $Framework = new \Devise\Support\Framework;
        $this->DvsPage = new \DvsPage;
        $this->PageVersionManager = m::mock('Devise\Pages\PageVersionManager');
        $this->PageVersionsRepository = m::mock('Devise\Pages\PageVersionsRepository');
        $this->FieldsRepository = m::mock('Devise\Pages\Fields\FieldsRepository');
        $this->FieldManager = m::mock('Devise\Pages\Fields\FieldManager');
        $this->RoutesGenerator = m::mock('Devise\Pages\RoutesGenerator');
        $this->Language = new \DvsLanguage;
        $this->PageManager = new PageManager($this->DvsPage, $this->PageVersionManager, $this->PageVersionsRepository, $this->FieldsRepository, $this->FieldManager, $Framework, $this->RoutesGenerator, $this->Language);
    }

    public function test_it_creates_new_page()
    {
        $this->PageVersionManager->shouldReceive('createDefaultPageVersion')->times(1)->andReturn(new \DvsPageVersion);
        $this->RoutesGenerator->shouldReceive('cacheRoutes')->once();
        $page = $this->PageManager->createNewPage(['title' => 'Some page title', 'slug' => '/some-page-title', 'http_verb' => 'get', 'view' => 'some.view.path']);
        assertNotFalse($page);
        assertInstanceOf('DvsPageVersion', $page->version);
        assertEquals($page->title, 'Some page title');
    }

    public function test_it_creates_new_page_for_spanish_language()
    {
        $this->PageVersionManager->shouldReceive('createDefaultPageVersion')->times(1)->andReturn(new \DvsPageVersion);
        $this->RoutesGenerator->shouldReceive('cacheRoutes')->once();
        $page = $this->PageManager->createNewPage(['title' => 'Some page title', 'slug' => '/some-page-title', 'http_verb' => 'get', 'view' => 'some.view.path', 'language_id' => 163]);
        assertNotFalse($page);
        assertInstanceOf('DvsPageVersion', $page->version);
        assertEquals($page->title, 'Some page title');
        assertEquals($page->route_name, 'es-some-page-title');
    }

    public function test_it_updates_page()
    {
        $this->RoutesGenerator->shouldReceive('cacheRoutes')->once();
        $page = $this->PageManager->updatePage(1, ['title' => 'Some page title', 'slug' => '/some-page-title', 'http_verb' => 'get', 'view' => 'some.view.path']);
        assertEquals('Some page title', $page->title);
    }

    public function test_it_destroys_page()
    {
        $this->RoutesGenerator->shouldReceive('cacheRoutes')->once();
        $this->PageManager->destroyPage(1);
        $deletedPage = \DvsPage::find(1);
        assertNull($deletedPage);
    }

    public function test_it_copies_page()
    {
        $this->RoutesGenerator->shouldReceive('cacheRoutes')->once();
        $this->PageVersionManager->shouldReceive('copyPageVersionToAnotherPage')->times(1);
        $newPage = $this->PageManager->copyPage(1, ['title' => 'Some page title', 'slug' => '/some-page-title', 'http_verb' => 'get', 'view' => 'some.view.path']);
        assertNotEquals(1, $newPage->id);
        assertEquals('Some page title', $newPage->title);
    }

    public function test_it_updates_page_version_dates()
    {
        $this->PageVersionManager->shouldReceive('updatePageVersionDates')->times(1)->with(1, ['some' => 'fake mock input']);
        $this->PageManager->updatePageVersionDates(1, ['some' => 'fake mock input']);
    }

    public function test_it_updates_page_version_view()
    {
        $this->PageVersionManager->shouldReceive('updatePageVersionView')->times(1)->with(1, 'view')->andReturn(true);
        $this->PageManager->updatePageVersionView(1, 'view');
    }

    public function test_it_can_mark_content_requested_fields_as_complete()
    {
        $this->PageVersionsRepository->shouldReceive('getVersionsListForPage')->times(1)->andReturn([1 => 'name1', 2 => 'name2']);
        $this->FieldsRepository->shouldReceive('findContentRequestedFieldsList')->times(1)->with(1)->andReturn(1);
        $this->FieldsRepository->shouldReceive('findContentRequestedFieldsList')->times(1)->with(2)->andReturn(2);
        $this->FieldManager->shouldReceive('markNoContentRequested')->times(1)->with(1)->andReturn(true);
        $this->FieldManager->shouldReceive('markNoContentRequested')->times(1)->with(2)->andReturn(true);
        $this->PageManager->markContentRequestedFieldsComplete(1);
    }

    public function test_it_can_toggle_ab_testing()
    {
        $page = $this->PageManager->toggleABTesting(1, true);
        $this->assertTrue($page->ab_testing_enabled);
        $page = $this->PageManager->toggleABTesting(1, false);
        $this->assertFalse($page->ab_testing_enabled);
    }

    public function test_it_can_update_page_version_ab_testing_amount()
    {
        $this->PageVersionManager->shouldReceive('updatePageVersionABTestingAmount')->times(1)->with(1, 50)->andReturnSelf();
        $this->PageManager->updatePageVersionABTestingAmount(1, 50);
    }
}