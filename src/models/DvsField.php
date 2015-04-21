<?php

use Devise\Pages\Fields\LiveFieldValue;

use Illuminate\Database\Eloquent\SoftDeletes;

class DvsField extends Eloquent
{
    use SoftDeletes;

    public $dvs_type = 'field';

    protected $softDelete = true;

	protected $table = 'dvs_fields';

    protected $guarded = array();

    protected $_value;

    protected $dates = ['deleted_at'];

    protected $appends = ['values', 'scope'];

    /**
     * This field belongs to a page
     *
     * @return belongsTo
     */
	public function pageVersion()
	{
		return $this->belongsTo('DvsPageVersion', 'page_version_id');
	}

    /**
     * Accessor on this model to get value
     * for the latestVersion of this field
     *
     * @return  FieldValue
     */
    public function getValueAttribute()
    {
        $json = $this->json_value ?: '{}';

        $this->_value = $this->_value ?: new LiveFieldValue($json, $this->id, 'field');

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
        return 'field';
    }

    /**
     * Overrides the toJson to handle
     * extracting values
     *
     * @return json
     */
    public function toJson($options = 0)
    {
        $this->getValueAttribute()->extract();

        return parent::toJson($options);
    }

    /**
     * Override the toArray to handle
     * extracting values
     *
     * @return array
     */
    public function toArray()
    {
        $this->getValueAttribute()->extract();

        return parent::toArray();
    }
}