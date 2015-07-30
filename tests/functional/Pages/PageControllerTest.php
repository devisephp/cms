<?php namespace Devise\Pages;

use Mockery as m;

class PageControllerTest extends \DeviseTestCase
{
    public function test_it_shows_view()
    {
        $DvsPage = new \DvsPage;
        $DvsPage->response_type = 'View';
        $DvsPage->view = 'some.view.path';
        $DvsPage->version = new \DvsPageVersion;

        $PagesRepository = m::mock('Devise\Pages\PagesRepository');
        $PagesRepository->shouldReceive('findByRouteName')->times(0)->andReturn($DvsPage);
        $PagesRepository->shouldReceive('findLocalizedPage')->times(1)->andReturn(null);
        $PagesRepository->shouldReceive('findByRouteNameAndPreviewHash')->times(1)->andReturn($DvsPage);

        $DataBuilder = m::mock('Devise\Pages\Viewvars\DataBuilder');
        $DataBuilder->shouldReceive('setData')->times(1);
        $DataBuilder->shouldReceive('getData')->times(1)->andReturn(['some' => 'fake data']);

        $Input = m::mock('Illuminate\Http\Request');
        $Input->shouldReceive('all')->times(1)->andReturn([]);
        $Input->shouldReceive('get')->times(2)->andReturn('Default');

        $View = m::mock('Illuminate\View\View');
        $View->shouldReceive('make')->times(1)->with('some.view.path', ['some' => 'fake data']);

        $Route = m::mock('Illuminate\Routing\Route');
        $Route->shouldReceive('getCurrentRoute')->times(1)->andReturnSelf();
        $Route->shouldReceive('parameters')->times(1)->andReturnSelf();
        $Route->shouldReceive('currentRouteName')->times(1)->andReturn('some.route.name');

        $PageController = new PageController($PagesRepository, $DataBuilder, $Input, $View, $Route);
        $PageController->show();
    }

    public function test_it_shows_function()
    {
        $DvsPage = new \DvsPage;
        $DvsPage->response_type = 'Function';
        $DvsPage->response_path = 'Fake\Class\That\Doesnt\Exist.someMethod';
        $DvsPage->response_params = null;

        $PagesRepository = m::mock('Devise\Pages\PagesRepository');
        $PagesRepository->shouldReceive('findByRouteName')->times(0)->andReturn($DvsPage);
        $PagesRepository->shouldReceive('findLocalizedPage')->times(1)->andReturn(null);
        $PagesRepository->shouldReceive('findByRouteNameAndPreviewHash')->times(1)->andReturn($DvsPage);

        $DataBuilder = m::mock('Devise\Pages\Viewvars\DataBuilder');
        $DataBuilder->shouldReceive('setData')->times(1);
        $DataBuilder->shouldReceive('getValue')->times(1);

        $Input = m::mock('Illuminate\Http\Request');
        $Input->shouldReceive('all')->times(1)->andReturn([]);
        $Input->shouldReceive('get')->times(2)->andReturn('Default');

        $View = m::mock('Illuminate\View\View');

        $Route = m::mock('Illuminate\Routing\Route');
        $Route->shouldReceive('getCurrentRoute')->times(1)->andReturnSelf();
        $Route->shouldReceive('parameters')->times(1)->andReturnSelf();
        $Route->shouldReceive('currentRouteName')->times(1)->andReturn('some.route.name');

        $PageController = new PageController($PagesRepository, $DataBuilder, $Input, $View, $Route);
        $PageController->show();
    }
}
