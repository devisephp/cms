<?php namespace Devise\Cms;

use Devise\Fields\FieldHelper;

class DeviseCms
{
	public function __construct(FieldHelper $FieldHelper)
	{
		$this->FieldHelper = $FieldHelper;
	}

	public function field($key, $type, $humanName = null, $group = null, $category = null, $alternateTarget = null)
	{
		return $this->FieldHelper->dataBind($key, $type, $humanName, $group, $category, $alternateTarget);
	}
}