<?php namespace Devise\Calendar;

use DateTime;

class PageVersionSource implements Source
{
	public function fetchEvents($start, $end)
	{
		$data = array();

		$data[] = new Event('Some title 1', new DateTime);
		$data[] = new Event('Some title 2', new DateTime);
		$data[] = new Event('Some title 3', new DateTime, (new DateTime)->modify('+3 days'));
		$data[2]->editable = true;

		return $data;
	}
}
