<?php

use Devise\Fields\Models\FieldValue;

class Field extends Eloquent
{
    use SoftDeletingTrait;

    protected $softDelete = true;

	protected $table = 'dvs_fields';

    protected $guarded = array();

    protected $_value;

    protected $dates = ['deleted_at'];

    /**
     * This field belongs to a page
     *
     * @return belongsTo
     */
	public function page()
	{
		return $this->belongsTo('Page');
	}

    /**
     * All version of this field
     *
     * @return hasMany
     */
    public function versions()
    {
        return $this->hasMany('FieldVersion');
    }

    /**
     * Latest published version of this field
     *
     * @return hasOne
     */
    public function latestPublishedVersion()
    {
        return $this->hasOne('FieldVersion')
            ->where('stage', '=', 'published')
            ->orderBy('published_at', 'DESC');
    }

    /**
     * Latest staging version of this field
     *
     * @return hasOne
     */
    public function latestStagingVersion()
    {
        return $this->hasOne('FieldVersion')
            ->where('stage', '=', 'staging')
            ->orderBy('published_at', 'DESC');
    }

    /**
     * Accessor on this model to get value
     * for the latestVersion of this field
     *
     * @return  FieldValue
     */
    public function getValueAttribute()
    {
        $this->_value = $this->_value ?: $this->value($this->latestPublishedVersion);

        return $this->_value;
    }

    /**
     * Accessor on this model to get value
     * for the latestVersion of this field
     *
     * @return  FieldValue
     */
    public function getValuesAttribute()
    {
        $this->_value = $this->_value ?: $this->value($this->latestPublishedVersion);

        return $this->_value;
    }

    /**
     * Let's us know if the scope of this field is global or page
     *
     * @return [type] [description]
     */
    public function getScopeAttribute()
    {
        return $this->page_id == 0 ? 'global' : 'page';
    }

    /**
     * Function to get the value of this
     * version of the field
     *
     * @param  FieldVersion $version
     * @return FieldValue
     */
    public function value($version)
    {
        return $version ? new FieldValue($version->value)
                : new FieldValue('{}');
    }
}