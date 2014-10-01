<?php

use Devise\Fields\Models\FieldValue;

class FieldVersion extends Eloquent
{
	protected $table = 'dvs_field_versions';

	protected $guarded = array();

	protected $_values = null;
	
	public function field()
	{
		return $this->belongsTo('Field');
	}

	public function user()
	{
		return $this->belongsTo('User', 'responsible_user_id');
	}

	public function getValuesAttribute()
	{
		if (!$this->_values) $this->_values = new FieldValue($this->value);
		return $this->_values;
	}
}