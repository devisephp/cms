<?php namespace Devise\Calendar;

class Event implements \JsonSerializable
{
	/**
	 * Date format that start and end dates are
	 * in. This format is parsed when we send json
	 * out too
	 *
	 * @var string
	 */
	public $dateFormat = "Y-m-d\TH:i:sO";


	/**
	 * Uniquely identifies the given event. Different instances of
	 * repeating events should all have the same id.
	 *
	 * @var integer | string
	 */
	public $id;


	/**
	 * The text on an event's element. Required.
	 *
	 * @var string
	 */
	public $title;


	/**
	 * Whether an event occurs at a specific time-of-day.
	 * This property affects whether an event's time is shown.
	 * Also, in the agenda views, determines if it is displayed
	 * in the "all-day" section. If this value is not explicitly
	 * specified, allDayDefault will be used if it is defined.
	 *
	 * If all else fails, FullCalendar will try to guess. If either
	 * the start or end value has a "T" as part of the ISO8601 date
	 * string, allDay will become false. Otherwise, it will be true.
	 *
	 * Don't include quotes around your true/false.
	 * This value is a boolean, not a string!
	 *
	 * @var boolean
	 */
	public $allDay;


	/**
	 * The date/time an event begins. Required.
	 *
	 * @var ISO8601
	 */
	public $start;


	/**
	 * The exclusive date/time an event ends. Optional.
	 * It is the moment immediately after the event has ended.
	 * For example, if the last full day of an event is Thursday,
	 * the exclusive end of the event will be 00:00:00 on Friday!
	 *
	 * @var ISO8601
	 */
	public $end;


	/**
	 * A URL that will be visited when this event is clicked by the user.
	 * For more information on controlling this behavior, see the eventClick callback.
	 *
	 * @var string
	 */
	public $url;


	/**
	 * A CSS class (or array of classes) that will be attached to this event's element.
	 *
	 * @var array(string)
	 */
	public $className;


	/**
	 * Overrides the master editable option for this single event.
	 *
	 * @var boolean
	 */
	public $editable;


	/**
	 * Overrides the master eventStartEditable option for this single event.
	 *
	 * @var boolean
	 */
	public $startEditable;


	/**
	 * Overrides the master eventDurationEditable option for this single event.
	 *
	 * @var boolean
	 */
	public $durationEditable;


	/**
	 * Allows alternate rendering of the event, like background events.
	 * Can be empty, "background", or "inverse-background"
	 *
	 * @var string
	 */
	public $rendering;


	/**
	 * Overrides the master eventOverlap option for this single event.
	 * If false, prevents this event from being dragged/resized over other
	 * events. Also prevents other events from being dragged/resized over this event.
	 *
	 * @var boolean
	 */
	public $overlap;


	/**
	 * An event ID, "businessHours", object. Optional.
	 * Overrides the master eventConstraint option for this single event.
	 *
	 * @var string
	 */
	public $constraint;


	/**
	 * Event Source Object. Automatically populated.
	 * A reference to the event source that this event came from.
	 *
	 * @var EventSource
	 */
	public $source;


	/**
	 * Sets an event's background and border color just like the
	 * calendar-wide eventColor option.
	 *
	 * @var string|hex
	 */
	public $color;


	/**
	 * Sets an event's background color just like the calendar-wide
	 * eventBackgroundColor option.
	 *
	 * @var string|hex
	 */
	public $backgroundColor;


	/**
	 * Sets an event's border color just like the the calendar-wide
	 * eventBorderColor option.
	 *
	 * @var string|hex
	 */
	public $borderColor;


	/**
	 * Sets an event's text color just like the calendar-wide
	 * eventTextColor option.
	 *
	 * @var string|hex
	 */
	public $textColor;

	/**
	 * Create a new Event object
	 *
	 * @param string   $title
	 * @param DateTime $start
	 * @param DateTime $end
	 */
	public function __construct($title, $start, $end = null)
	{
		if (is_null($title))
		{
 			throw new \Exception("An event must have a title");
		}

 		if (is_null($start))
 		{
 			throw new \Exception("An event must have a start date");
 		}

		$this->title = $title;
		$this->start = is_a($start, 'DateTime') ? $start->format($this->dateFormat) : $start;
		$this->end = is_a($end, 'DateTime') ? $end->format($this->dateFormat) : $end;
	}

	/**
	 * Describes how this class should be serialized
	 *
	 * @return array
	 */
	public function jsonSerialize()
	{
		$json = [];

		$json['title'] = $this->title;
		$json['start'] = $this->start;

		if ($this->id) $json['id'] = $this->id;
		if ($this->allDay) $json['allDay'] = $this->allDay;
		if ($this->end) $json['end'] = $this->end;
		if ($this->url) $json['url'] = $this->url;
		if ($this->className) $json['className'] = $this->className;
		if ($this->editable) $json['editable'] = $this->editable;
		if ($this->startEditable) $json['startEditable'] = $this->startEditable;
		if ($this->durationEditable) $json['durationEditable'] = $this->durationEditable;
		if ($this->rendering) $json['rendering'] = $this->rendering;
		if ($this->overlap) $json['overlap'] = $this->overlap;
		if ($this->constraint) $json['constraint'] = $this->constraint;
		if ($this->source) $json['source'] = $this->source;
		if ($this->color) $json['color'] = $this->color;
		if ($this->backgroundColor) $json['backgroundColor'] = $this->backgroundColor;
		if ($this->borderColor) $json['borderColor'] = $this->borderColor;
		if ($this->textColor) $json['textColor'] = $this->textColor;

		return $json;
	}

}