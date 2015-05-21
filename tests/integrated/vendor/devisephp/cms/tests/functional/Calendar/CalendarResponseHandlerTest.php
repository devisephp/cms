<?php namespace Devise\Calendar;

use Mockery as m;

class CalendarResponseHandlerTest extends \DeviseTestCase
{
	public function setUp()
	{
		parent::setUp();
		$this->Framework = new \Devise\Support\Framework;
		$this->Framework->Response = m::mock('MockResponse');
		$this->PageVersionSource = m::mock('Devise\Calendar\PageVersionSource');
		$this->CalendarResponseHandler = new CalendarResponseHandler($this->Framework, $this->PageVersionSource);
	}

	public function test_it_can_request_page_version_source()
	{
		$this->PageVersionSource->shouldReceive('fetchEvents')->andReturn(array());
		$this->Framework->Response->shouldReceive('json')->andReturn(array());
		assertEquals(array(), $this->CalendarResponseHandler->requestPageVersionEventSource(['start' => '', 'end' => '']));
	}

	public function test_it_can_request_page_version_event_update()
	{
		$this->Framework->Response->shouldReceive('json')->andReturn(array());
		$this->PageVersionSource->shouldReceive('updatePageVersion')->andReturn(array());
		assertEquals(array(), $this->CalendarResponseHandler->requestPageVersionEventUpdate(1, ['start' => '', 'end' => '', 'published' => false]));
	}
}