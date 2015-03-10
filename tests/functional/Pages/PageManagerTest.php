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

        $this->PageManager = new PageManager($this->DvsPage, $this->PageVersionManager, $this->PageVersionsRepository, $this->FieldsRepository, $this->FieldManager, $Framework);
    }

    public function test_it_creates_new_page()
    {
        $this->PageVersionManager->shouldReceive('createDefaultPageVersion')->times(1)->andReturn(new \DvsPageVersion);
        $page = $this->PageManager->createNewPage(['title' => 'Some page title', 'slug' => '/some-page-title', 'http_verb' => 'get', 'view' => 'some.view.path']);
        assertNotFalse($page);
        assertInstanceOf('DvsPageVersion', $page->version);
        assertEquals($page->title, 'Some page title');
    }

    public function test_it_updates_page()
    {
        $page = $this->PageManager->updatePage(1, ['title' => 'Some page title', 'slug' => '/some-page-title', 'http_verb' => 'get', 'view' => 'some.view.path']);
        assertEquals('Some page title', $page->title);
    }

    public function test_it_destroys_page()
    {
        $this->PageManager->destroyPage(1);
        $deletedPage = \DvsPage::find(1);
        assertNull($deletedPage);
    }

    public function test_it_copies_page()
    {
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
}