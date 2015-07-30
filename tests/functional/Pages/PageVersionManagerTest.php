<?php namespace Devise\Pages;

use Mockery as m;

class PageVersionManagerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $this->UserHelper = m::mock('Devise\Users\UserHelper');
        $this->PageVersion = new \DvsPageVersion;
        $this->Field = new \DvsField;
        $this->CollectionInstance = new \DvsCollectionInstance;
        $this->PagesRepository = m::mock('Devise\Pages\PagesRepository');
        $this->PageVersionManager = new PageVersionManager($this->UserHelper, $this->PageVersion, $this->Field, $this->CollectionInstance, $this->PagesRepository);
    }

    public function test_it_can_create_new_page_version()
    {
        $version = $this->PageVersionManager->createNewPageVersion($pageId = 1, $name = 'Some Version', $createdByuserId = 1);
        assertInstanceOf('DvsPageVersion', $version);
    }

    public function test_it_creates_default_page_version()
    {
        $this->createTestPage(['id' => 12345]);
        $page = \DvsPage::find(12345);
        $this->UserHelper->shouldReceive('currentUserId')->times(1)->andReturn(1);
        $version = $this->PageVersionManager->createDefaultPageVersion($page);
        assertInstanceOf('DvsPageVersion', $version);
    }

    public function test_it_copies_page_version_to_another_page()
    {
        $this->UserHelper->shouldReceive('currentUserId')->times(1)->andReturn(1);
        $this->createTestPage(['id' => 12345]);
        $toPage = \DvsPage::find(12345);
        $version = \DvsPageVersion::find(1);
        $newVersion = $this->PageVersionManager->copyPageVersionToAnotherPage($version, $toPage);
        assertInstanceOf('DvsPageVersion', $newVersion);
    }

    public function test_it_copies_page_version_to_new_name()
    {
        $this->UserHelper->shouldReceive('currentUserId')->times(1)->andReturn(1);
        $newVersion = $this->PageVersionManager->copyPageVersion(1, 'New Instance');
        assertInstanceOf('DvsPageVersion', $newVersion);
    }

    public function test_it_updates_page_version_dates()
    {
        $input = ['starts_at' => new \DateTime, 'ends_at' => new \DateTime('+1 day')];
        $version = $this->PageVersionManager->updatePageVersionDates(1, [
            'starts_at' => $input['starts_at']->format('m/d/y H:i:s'),
            'ends_at' => $input['ends_at']->format('m/d/y H:i:s')
        ]);
        assertEquals($input['starts_at']->format('Y-m-d H:i:s'), $version->starts_at);
        assertEquals($input['ends_at']->format('Y-m-d H:i:s'), $version->ends_at);
    }

    public function test_it_updates_page_version_ab_testing_amount()
    {
        $version = $this->PageVersionManager->updatePageVersionABTestingAmount(1, 100);
        assertEquals(100, $version->ab_testing_amount);
    }

    /**
     * @expectedException \Devise\Support\DeviseException
     */
    public function test_it_cannot_delete_live_page_version()
    {
        $page = \DvsPage::find(1);
        $pageVersion = \DvsPageVersion::find(1);
        $this->PagesRepository->shouldReceive('find')->andReturn($page);
        $this->PagesRepository->shouldReceive('getLivePageVersion')->andReturn($pageVersion);
        $this->PageVersionManager->destroyPageVersion(1);
    }

    public function test_it_can_delete_nonlive_page_version()
    {
        $page = \DvsPage::find(1);
        $pageVersion = \DvsPageVersion::find(2);
        $this->PagesRepository->shouldReceive('find')->andReturn($page);
        $this->PagesRepository->shouldReceive('getLivePageVersion')->andReturn($pageVersion);
        $this->PageVersionManager->destroyPageVersion(1);
    }

    public function test_it_toggles_page_version_preview_share()
    {
        $this->PageVersionManager->togglePageVersionPreviewShare(1);
        $version = \DvsPageVersion::find(1);
        assertNotNull($version->preview_hash);
    }

    public function test_it_updates_page_version_view()
    {
        $this->PageVersionManager->updatePageVersionView(1, 'some.view');
        $version = \DvsPageVersion::find(1);
        assertEquals('some.view', $version->view);
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
