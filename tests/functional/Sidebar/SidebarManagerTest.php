<?php namespace Devise\Sidebar;

use Mockery as m;

class SidebarManagerTest extends \DeviseTestCase
{
    public function test_it_fetches_partial_view()
    {
        $SidebarData = new SidebarData;
        $SidebarDataTranslator = m::mock('Devise\Sidebar\SidebarDataTranslator');
        $SidebarDataTranslator->shouldReceive('translateFromInputArray')->andReturn($SidebarData);
        $PagesRepository = m::mock('Devise\Pages\PagesRepository');
        $PagesRepository->shouldReceive('availableLanguagesForPage')->andReturn([]);
        $PagesRepository->shouldReceive('getRouteList')->andReturn([]);
        $PagesRepository->shouldReceive('getPageVersions')->andReturn([]);
        $FieldsRepository = m::mock('Devise\Pages\Fields\FieldsRepository');
        $View = m::mock('Mocked\View');
        $View->shouldReceive('make')->andReturnSelf();
        $View->shouldReceive('render')->andReturn('some html here');
        $SidebarManager = new SidebarManager($SidebarDataTranslator, $PagesRepository, $FieldsRepository, $View);
        $SidebarManager->fetchPartialView(['page_id' => 1, 'page_version_id' => 1]);
    }

    public function test_it_fetches_element_view()
    {
        $DvsField = new \DvsField;
        $SidebarData = new SidebarData;
        $SidebarDataTranslator = m::mock('Devise\Sidebar\SidebarDataTranslator');
        $SidebarDataTranslator->shouldReceive('translateFromInputArray')->andReturn($SidebarData);
        $PagesRepository = m::mock('Devise\Pages\PagesRepository');
        $PagesRepository->shouldReceive('availableLanguagesForPage')->andReturn([]);
        $PagesRepository->shouldReceive('getRouteList')->andReturn([]);
        $PagesRepository->shouldReceive('getPageVersions')->andReturn([]);
        $FieldsRepository = m::mock('Devise\Pages\Fields\FieldsRepository');
        $FieldsRepository->shouldReceive('findFieldByIdAndScope')->andReturn($DvsField);
        $View = m::mock('Mocked\View');
        $View->shouldReceive('make')->andReturnSelf();
        $View->shouldReceive('render')->andReturn('some html here');
        $SidebarManager = new SidebarManager($SidebarDataTranslator, $PagesRepository, $FieldsRepository, $View);
        $SidebarManager->fetchElementView(['field_id' => 1, 'field_scope' => 'page']);
    }

    public function test_it_fetches_element_grid_view()
    {
        $SidebarData = new SidebarData;
        $SidebarDataTranslator = m::mock('Devise\Sidebar\SidebarDataTranslator');
        $SidebarDataTranslator->shouldReceive('translateFromInputArray')->andReturn($SidebarData);
        $PagesRepository = m::mock('Devise\Pages\PagesRepository');
        $PagesRepository->shouldReceive('availableLanguagesForPage')->andReturn([]);
        $PagesRepository->shouldReceive('getRouteList')->andReturn([]);
        $PagesRepository->shouldReceive('getPageVersions')->andReturn([]);
        $FieldsRepository = m::mock('Devise\Pages\Fields\FieldsRepository');
        $View = m::mock('Mocked\View');
        $View->shouldReceive('make')->andReturnSelf();
        $View->shouldReceive('render')->andReturn('some html here');
        $SidebarManager = new SidebarManager($SidebarDataTranslator, $PagesRepository, $FieldsRepository, $View);
        $SidebarManager->fetchElementGridView(['page_id' => 1, 'page_version_id' => 1]);
    }

}