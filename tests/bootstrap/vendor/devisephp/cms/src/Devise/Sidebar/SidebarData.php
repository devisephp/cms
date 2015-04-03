<?php namespace Devise\Sidebar;

/**
 * Class SidebarData is a structured data object whose
 * primary job is hold the properties you see below so
 * we don't have to deal with an array, instead we get a
 * nice clean object to work with.
 * @package Devise\Sidebar
 */
class SidebarData
{
    /**
     * Coordinates on the page
     *
     * @var null|object
     */
	public $coordinates = null;

    /**
     * Category name
     *
     * @var string
     */
	public $categoryName = "";

    /**
     * THe number of categories that were
     * passed in via data input
     *
     * @var int
     */
	public $categoryCount = 0;

    /**
     * Listing of groups
     *
     * @var array
     */
	public $groups = array();

    /**
     * Elements are actual fields in the database
     *
     * @var array
     */
	public $elements = array();

    /**
     * Constructs a new SidebarData instance
     */
	public function __construct()
	{
		$this->coordinates = (object) (array('top' => 0, 'left' => 0));
	}
}