<?php namespace Devise\Calendar;

use Mockery as m;

class PageVersionSourceTest extends \DeviseTestCase
{
	public function setUp()
	{
		parent::setUp();

		\DvsPage::create([
			'id' => 9999,
			'language_id' => 45,
			'title' => 'Some title',
			'is_admin' => 0,
			'dvs_admin' => 0,
			'route_name' => 'some-route-name',
			'slug' => 'some/route',
		]);

		\DvsPageVersion::create([
			'id' => 9999,
			'page_id' => 9999,
			'created_by_user_id' => 0,
			'name' => 'Default',
			'starts_at' => '2015-01-02 00:00:00',
			'ends_at' => '2015-01-03 00:00:00',
		]);

		$this->Framework = new \Devise\Support\Framework;
		$this->Framework->URL = m::mock('MockedURL');
		$this->Framework->URL->shouldReceive('route')->andReturn('admin/calendar/sources/page-versions/id');
		$this->PageVersionSource = new PageVersionSource(new \DvsPageVersion, $this->Framework);
	}

	public function test_it_fetches_events()
	{
		assertCount(1, $this->PageVersionSource->fetchEvents('2015-01-01 00:00:00', '2015-01-21 00:00:00'));
	}

	public function test_it_updates_page_version()
	{
		$event = $this->PageVersionSource->updatePageVersion(9999, '2015-01-01 00:00:00', '2015-01-01 23:59:59', $published = true);

		assertEquals(9999, $event->id);
		assertEquals('2015-01-01 00:00:00', $event->start);
		assertEquals(true, $event->published);
	}
}