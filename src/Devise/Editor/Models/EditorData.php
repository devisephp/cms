<?php namespace Devise\Editor\Models;

use stdClass;

class EditorData
{
	public $coordinates = null;

	public $categoryName = "";

	public $categoryCount = 0;

	public $groups = array();

	public $elements = array();

	public function __construct()
	{
		$this->coordinates = (object) (array('top' => 0, 'left' => 0));
	}
}