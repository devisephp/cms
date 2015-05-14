<?php

use Devise\Pages\Fields\LiveFieldValue;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class DvsGlobalField extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

	protected $table = 'dvs_global_fields';

    protected $guarded = array();

    protected $_value;

    protected $dates = ['deleted_at'];

    protected $appends = ['values', 'scope'];

    /**
     * Accessor on this model to get value
     * for the latestVersion of this field
     *
     * @return  FieldValue
     */
    public function getValueAttribute()
    {
        $json = $this->json_value ?: '{}';
        $this->_value = $this->_value ?: new LiveFieldValue($json, $this->id, 'global');
        return $this->_value;
    }

    /**
     * Sometimes we've been using values instead of value
     * so this is here for backwards compatability support
     *
     * @return FieldValue
     */
    public function getValuesAttribute()
    {
        return $this->getValueAttribute();
    }

    /**
     * Let's us know if the scope of this field is global or page
     *
     * @return string
     */
    public function getScopeAttribute()
    {
        return 'global';
    }
}