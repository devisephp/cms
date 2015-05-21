<?php namespace Devise\Calendar;

use Devise\Support\Framework;

/**
 * Handles the ajax calls made to backend from the Full Calendar
 */
class CalendarResponseHandler
{
	/**
	 * Handles responses sent to client
	 *
	 * @var Response
	 */
	private $Response;

	/**
	 * Holds the Page Version Source
	 * @var PageVersionSource
	 */
	private $PageVersionSource;

	/**
	 * Construct a new CalendarResponseHandler
	 *
	 * @param Framework         $Framework
	 * @param PageVersionSource $PageVersionSource
	 */
	public function __construct(Framework $Framework, PageVersionSource $PageVersionSource)
	{
		$this->Response = $Framework->Response;
		$this->PageVersionSource = $PageVersionSource;
	}

	/**
	 * Requests the json for a given start and stop date for a given page source
	 *
	 * @param  array $input
	 * @return Response
	 */
	public function requestPageVersionEventSource($input)
	{
		$start = array_get($input, 'start');
		$end = array_get($input, 'end');

		return $this->Response->json($this->PageVersionSource->fetchEvents($start, $end));
	}

	/**
	 * Requests that a page version event's start and end times
	 * be updated
	 *
	 * @param  int   $id
	 * @param  array $input
	 * @return Response
	 */
	public function requestPageVersionEventUpdate($id, $input)
	{
		$start = array_get($input, 'start');
		$end = array_get($input, 'end');
		$published = array_get($input, 'published', false);
		$event = $this->PageVersionSource->updatePageVersion($id, $start, $end, $published);

		return $this->Response->json($event);
	}
}