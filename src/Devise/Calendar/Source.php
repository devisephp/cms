<?php namespace Devise\Calendar;

interface Source
{
	public function fetchEvents($start, $end);
}