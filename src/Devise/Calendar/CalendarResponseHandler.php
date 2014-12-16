<?php namespace Devise\Calendar;

use Devise\Support\Framework;

class CalendarResponseHandler
{
	private $Response;

	private $PageVersionSource;

	public function __construct(Framework $Framework, PageVersionSource $PageVersionSource)
	{
		$this->Response = $Framework->Response;
		$this->PageVersionSource = $PageVersionSource;
	}

	public function requestPageVersionEventSource($input)
	{
		$start = array_get($input, 'start');
		$end = array_get($input, 'end');

		return $this->Response->json($this->PageVersionSource->fetchEvents($start, $end));
	}
}