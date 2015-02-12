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

	// public function fetchSpecificFields($allowedFields)
	// {
	// 	$allowedFields = is_array($allowedFields) ? $allowedFields : $this->parseAllowedFields($allowedFields);
	// 	return $allowedFields ? array_merge(array_fill_keys($allowedFields, ''), array_only($this->overrides, $allowedFields)) : [];
	// }

	// protected function parseAllowedFields($fields)
	// {
	// 	return explode(',', str_replace(' ', '', $fields));
	// }
}