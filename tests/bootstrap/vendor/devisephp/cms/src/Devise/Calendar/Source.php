<?php namespace Devise\Calendar;

/**
 * A source is a plage to fetch events given a start and
 * end time. Our CalendarResponseHandler will use the
 * PageVersionSource (and others possibly later) so I
 * made an interface we can all abide by if we need to
 * create more event sources for the full calendar
 *
 */
interface Source
{
	/**
	 * Returns a list of events in FullCalendar Event format.
	 * The format can be found here:
	 *    http://fullcalendar.io/docs/event_data/Event_Object/
	 *
	 * @param  string $start
	 * @param  string $end
	 * @return array(StdClass)
	 */
	public function fetchEvents($start, $end);
}