<?php namespace Devise\Calendar;

use Devise\Support\Framework;

/**
 * Purpose of this class is to source out events
 * that are page versions in disguise. It also handles
 * updating a page version event if the user has changed
 * it on the front end calendar ...
 */
class PageVersionSource implements Source
{
	/**
	 * Create a new PageVersionSource
	 *
	 * @param DvsPageVersion $PageVersion
	 */
	public function __construct(\DvsPageVersion $PageVersion, Framework $Framework)
	{
		$this->PageVersion = $PageVersion;
		$this->URL = $Framework->URL;
	}

	/**
	 * A Source must be able to fetch events. On this source we
	 * treat page versions as events with start and end dates.
	 *
	 * @param  string $start
	 * @param  string $end
	 * @return array(StdClass)
	 */
	public function fetchEvents($start, $end)
	{
		$events = [];

		$pageVersions = $this->PageVersion
			->with('page')
			->join('dvs_pages', 'dvs_pages.id', '=', 'dvs_page_versions.page_id')
			->where('dvs_pages.dvs_admin', '!=', '1')
			->where('starts_at', '>', $start)
			->where('starts_at', '<', $end)
			->select('dvs_page_versions.*')
			->get();

		foreach ($pageVersions as $pageVersion)
		{
			$events[] = $this->fetchEvent($pageVersion);
		}

		return $events;
	}

	/**
	 * This is here so that we can update a page version event
	 *
	 * @param  int     $id
	 * @param  string  $start
	 * @param  string  $end
	 * @param  boolean $published
	 * @return StdClass
	 */
	public function updatePageVersion($id, $start, $end, $published)
	{
		if (!$published)
		{
			$start = null;
			$end = null;
		}

		$pageVersion = $this->PageVersion->with('page')->findOrFail($id);
		$pageVersion->starts_at = $start !== '' ? $start : null;
		$pageVersion->ends_at = $end !== '' ? $end : null;
		$pageVersion->save();

		return $this->fetchEvent($pageVersion);
	}

	/**
	 * Transforms a page version into a stdClass in the
	 * full calendar event format that is expected
	 *
	 * @param  DvsPageVersion $pageVersion
	 * @return StdClass
	 */
	protected function fetchEvent($pageVersion)
	{
		$event = new \StdClass;

		$event->id = $pageVersion->id;
		$event->page = $pageVersion->page;
		$event->title = $pageVersion->name;
		$event->start = $pageVersion->starts_at;
		$event->end = $pageVersion->ends_at;
		$event->published = !is_null($pageVersion->starts_at);
		$event->page_slug = $pageVersion->page ? $pageVersion->page->slug : '';
		$event->update_url = $this->URL->route('dvs-calendar-page-version-source-update', $pageVersion->id);
		$event->editable = true;
		// $event->allDay = true;

		return $event;
	}
}
