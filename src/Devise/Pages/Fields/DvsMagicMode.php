<?php namespace Devise\Pages\Fields;

class DvsMagicMode
{
	/**
	 * [$enabled description]
	 * @var boolean
	 */
	protected $enabled = false;

	/**
	 * [enable description]
	 * @param  [type] $shouldEnable
	 * @return [type]
	 */
	public function enable()
	{
		$this->enabled = true;
	}

	/**
	 * [disable description]
	 * @param  boolean $shouldDisable
	 * @return [type]
	 */
	public function disable()
	{
		$this->enabled = false;
	}

	/**
	 * [enabled description]
	 * @return [type]
	 */
	public function enabled()
	{
		return $this->enabled;
	}

	/**
	 * [disabled description]
	 * @return [type]
	 */
	public function disabled()
	{
		return !$this->enabled;
	}
}