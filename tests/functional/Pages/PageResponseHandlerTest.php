<?php namespace Devise\Pages;

use Mockery as m;

class PageResponseHandlerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->PageManager = m::mock('Devise\Pages\PageManager');
        $this->PagesRepository = m::mock('Devise\Pages\PagesRepository');
        $this->PageVersionManager = m::mock('Devise\Pages\PageVersionManager');
        $this->Redirect = m::mock('Illuminate\Routing\Redirector');
        $this->PageResponseHandler = new PageResponseHandler($this->PageManager, $this->PagesRepository, $this->PageVersionManager, $this->Redirect);
    }

    public function test_it_can_request_new_page_creation()
    {
        $this->PageManager->shouldReceive('createNewPage')->times(1)->andReturn(new \DvsPage);
        $this->Redirect->shouldReceive('route')->times(1)->andReturnSelf();
        $this->Redirect->shouldReceive('with')->times(2)->andReturnSelf();
        $this->PageResponseHandler->requestCreateNewPage(['some' => 'fake input']);
    }

    public function test_it_cannot_request_invalid_page_creation()
    {
        $this->PageManager->errors = [];
        $this->PageManager->message = 'There was an error';
        $this->PageManager->shouldReceive('createNewPage')->times(1)->andReturn(false);
        $this->Redirect->shouldReceive('route')->times(1)->andReturnSelf();
        $this->Redirect->shouldReceive('withInput')->times(1)->andReturnSelf();
        $this->Redirect->shouldReceive('withErrors')->times(1)->andReturnSelf();
        $this->Redirect->shouldReceive('with')->times(1)->andReturnSelf();
        $this->PageResponseHandler->requestCreateNewPage(['some' => 'fake input']);
    }

    public function test_it_can_request_page_updates()
    {
        $this->PageManager->shouldReceive('updatePage')->times(1)->andReturn(new \DvsPage);
        $this->Redirect->shouldReceive('route')->times(1)->andReturnSelf();
        $this->Redirect->shouldReceive('with')->times(2)->andReturnSelf();
        $this->PageResponseHandler->requestUpdatePage(1, ['some' => 'fake input']);
    }

    public function test_it_cannot_request_invalid_page_update()
    {
        $this->PageManager->errors = [];
        $this->PageManager->message = 'There was an error';
        $this->PageManager->shouldReceive('updatePage')->times(1)->andReturn(false);
        $this->Redirect->shouldReceive('route')->times(1)->andReturnSelf();
        $this->Redirect->shouldReceive('withInput')->times(1)->andReturnSelf();
        $this->Redirect->shouldReceive('withErrors')->times(1)->andReturnSelf();
        $this->Redirect->shouldReceive('with')->times(1)->andReturnSelf();
        $this->PageResponseHandler->requestUpdatePage(1, ['some' => 'fake input']);
    }

    public function test_it_can_request_page_deletion()
    {
        $this->PageManager->shouldReceive('destroyPage')->times(1)->andReturn(true);
        $this->Redirect->shouldReceive('route')->times(1)->andReturnSelf();
        $this->Redirect->shouldReceive('with')->times(2)->andReturnSelf();
        $this->PageResponseHandler->requestDestroyPage(1);
    }

    public function test_it_can_request_page_copy()
    {
        $this->PageManager->shouldReceive('copyPage')->times(1)->andReturn(true);
        $this->Redirect->shouldReceive('route')->times(1)->andReturnSelf();
        $this->Redirect->shouldReceive('with')->times(2)->andReturnSelf();
        $this->PageResponseHandler->requestCopyPage(1, ['some' => 'fake input']);
    }

    public function test_it_can_request_page_version_creation()
    {
        $this->PageVersionManager->shouldReceive('copyPageVersion')->times(1);
        $this->PageResponseHandler->requestStorePageVersion(['page_version_id' => 1, 'name' => 'durka']);
    }

    public function test_it_can_request_page_version_deletion()
    {
        $this->PageVersionManager->shouldReceive('destroyPageVersion')->times(1)->with(10)->andReturn(true);
        $this->PageResponseHandler->requestDestroyPageVersion(10);
    }

    public function test_it_can_request_page_list()
    {
        $input = ['term' => 2014];
        $this->PagesRepository->shouldReceive('getPagesList')->with(false, $input['term'])->times(1);
        $this->PageResponseHandler->requestPageList($input);
    }

    public function test_it_can_request_update_page_version_dates()
    {
        $this->PageManager->shouldReceive('updatePageVersionDates')->with(1, ['some' => 'fake data']);
        $this->PageResponseHandler->requestUpdatePageVersionDates(1, ['some' => 'fake data']);
    }

    public function test_it_can_request_toggle_page_version_share()
    {
        $this->PageVersionManager->shouldReceive('togglePageVersionPreviewShare')->times(1)->with(1)->andReturn(true);
        $this->PageResponseHandler->requestTogglePageVersionShare(1);
    }

    public function test_it_can_request_toggle_ab_testing()
    {
        $this->PageManager->shouldReceive('toggleABTesting')->times(1)->with(1, true)->andReturn(true);
        $this->PageResponseHandler->requestToggleAbTesting(['pageId' => 1, 'enabled' => true]);
    }

    public function test_it_can_request_update_page_version_ab_testing()
    {
        $this->PageManager->shouldReceive('updatePageVersionABTestingAmount')->times(1)->with(1, 50)->andReturnSelf();
        $this->PageResponseHandler->requestUpdatePageVersionAbTesting(['pageVersionId' => 1, 'amount' => 50]);
    }

    public function test_it_can_request_update_page_version_template()
    {
        $this->PageManager->shouldReceive('updatePageVersionView')->times(1)->with(1, 'some.view')->andReturnSelf();
        $this->PageResponseHandler->requestUpdatePageVersionTemplate(1, ['view' => 'some.view']);
    }
}