<?php namespace Devise\Support\Config;

use Devise\Support\Framework;

class SettingsRepository
{
	public function __construct($overrides = null)
	{
		$this->overrides = $overrides ?: include with(new Framework)->Container['config.overrides.file'];
	}

	public function fetchAllOverrides()
	{
		return $this->overrides;
	}
}