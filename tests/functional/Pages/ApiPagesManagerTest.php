<?php namespace Devise\Pages;

use Mockery as m;

class ApiPagesManagerTest extends \DeviseTestCase
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
        $this->ApiPagesManager = new ApiPagesManager($this->DvsPage, $this->PageVersionManager, $this->PageVersionsRepository, $this->FieldsRepository, $this->FieldManager, $Framework, $this->RoutesGenerator);
    }

    public function test_it_creates_new_page()
    {
        $this->PageVersionManager->shouldReceive('createDefaultPageVersion')->times(1)->andReturn(new \DvsPageVersion);
        $page = $this->ApiPagesManager->createNewPage(['title' => 'Some page title', 'slug' => '/some-page-title', 'http_verb' => 'get', 'response_path' => 'some.path','response_params'=>'param1,param2']);
        assertNotFalse($page);
        assertInstanceOf('DvsPageVersion', $page->version);
        assertEquals($page->title, 'Some page title');
    }

    public function test_it_cant_create_new_page()
    {
        $this->PageVersionManager->shouldReceive('createDefaultPageVersion')->times(0);
        $page = $this->ApiPagesManager->createNewPage(['title' => 'Some page title', 'slug' => '/some-page-title', 'http_verb' => 'get']);
        assertFalse($page);
        assertEquals(count($this->ApiPagesManager->errors), 1);
    }
}