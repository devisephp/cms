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
        $FieldManager = m::mock('Devise\Pages\Fields\FieldManager');
        $ModelMapper = m::mock('Devise\Sidebar\ModelMapper');
        $View = m::mock('Mocked\View');
        $View->shouldReceive('make')->andReturnSelf();
        $View->shouldReceive('render')->andReturn('some html here');
        $SidebarManager = new SidebarManager($SidebarDataTranslator, $PagesRepository, $FieldsRepository, $ModelMapper, $FieldManager, $View);
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
        $FieldManager = m::mock('Devise\Pages\Fields\FieldManager');
        $ModelMapper = m::mock('Devise\Sidebar\ModelMapper');
        $View = m::mock('Mocked\View');
        $View->shouldReceive('make')->andReturnSelf();
        $View->shouldReceive('render')->andReturn('some html here');
        $SidebarManager = new SidebarManager($SidebarDataTranslator, $PagesRepository, $FieldsRepository, $ModelMapper, $FieldManager, $View);
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
        $FieldManager = m::mock('Devise\Pages\Fields\FieldManager');
        $ModelMapper = m::mock('Devise\Sidebar\ModelMapper');
        $View = m::mock('Mocked\View');
        $View->shouldReceive('make')->andReturnSelf();
        $View->shouldReceive('render')->andReturn('some html here');
        $SidebarManager = new SidebarManager($SidebarDataTranslator, $PagesRepository, $FieldsRepository, $ModelMapper, $FieldManager, $View);
        $SidebarManager->fetchElementGridView(['page_id' => 1, 'page_version_id' => 1]);
    }

    public function test_it_updates_model_with_fields()
    {
        $SidebarDataTranslator = m::mock('Devise\Sidebar\SidebarDataTranslator');
        $PagesRepository = m::mock('Devise\Pages\PagesRepository');
        $PagesRepository->shouldReceive('availableLanguagesForPage')->andReturn([]);
        $FieldsRepository = m::mock('Devise\Pages\Fields\FieldsRepository');
        $FieldManager = m::mock('Devise\Pages\Fields\FieldManager');
        $View = m::mock('Mocked\View');

        $ModelMapper = m::mock('Devise\Sidebar\ModelMapper');
        $ModelMapper->shouldReceive('update')->once()->andReturn(new \DvsUser);

        $SidebarManager = new SidebarManager($SidebarDataTranslator, $PagesRepository, $FieldsRepository, $ModelMapper, $FieldManager, $View);

        $output = $SidebarManager->updateModel(['class_name' => 'DvsUser', 'key' => 'someFieldKey', 'page_version_id' => 1, 'forms' => 'fooForms']);

        assertInstanceOf('DvsUser', $output);
    }

    public function test_it_can_create_model()
    {
         $SidebarDataTranslator = m::mock('Devise\Sidebar\SidebarDataTranslator');
        $PagesRepository = m::mock('Devise\Pages\PagesRepository');
        $PagesRepository->shouldReceive('availableLanguagesForPage')->andReturn([]);
        $FieldsRepository = m::mock('Devise\Pages\Fields\FieldsRepository');
        $FieldManager = m::mock('Devise\Pages\Fields\FieldManager');
        $View = m::mock('Mocked\View');

        $ModelMapper = m::mock('Devise\Sidebar\ModelMapper');
        $ModelMapper->shouldReceive('create')->andReturn(new \DvsUser);

        $SidebarManager = new SidebarManager($SidebarDataTranslator, $PagesRepository, $FieldsRepository, $ModelMapper, $FieldManager, $View);

        $output = $SidebarManager->createModel(['class_name' => 'DvsFooModel', 'key' => 'dvsFooModelKey', 'page_version_id' => 1, 'forms' => 'dvsFooForms']);

        assertInstanceOf('DvsUser', $output);
    }

    public function test_it_updates_group()
    {
        $this->markTestIncomplete();
    }
}