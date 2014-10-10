<?php

class PageVersion extends Eloquent
{
    use SoftDeletingTrait;

    protected $softDelete = true;

	protected $table = 'dvs_page_versions';

    protected $guarded = array();

    /**
     * Accessor on this model to get value
     * for the latestVersion of this field
     *
     * @return  FieldValue
     */
    public function getValuesAttribute()
    {
        return json_decode($this->value);
    }

    /**
     * Page versions belong to a page
     *
     * @return belongsTo Page
     */
    public function page()
    {
        return $this->belongsTo('Page');
    }

    /**
     * Page version has many fields
     *
     */
    public function fields()
    {
        return $this->hasMany('Field')->where('collection_instance_id', null);
    }

    /**
     * Page version has many collection fields
     */
    public function collectionFields()
    {
        return $this->hasMany('Field')->whereNotNull('collection_instance_id');
    }

    /**
     * Page version has many collection instances
     */
    public function collectionInstances()
    {
        return $this->hasMany('CollectionInstance');
    }
}