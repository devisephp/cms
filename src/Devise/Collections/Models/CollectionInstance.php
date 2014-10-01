<?php

use DB;

class CollectionInstance extends Eloquent
{
	protected $table = 'dvs_collection_instance';

    protected $guarded = array();

    protected $_value;
    /**
     * All version of this field
     *
     * @return hasMany
     */
    public function collectionSet()
    {
        return $this->belongsTo('CollectionSet');
    }

    /**
     * All version of this FieldVersion
     *
     * @return hasMany
     */
    public function fieldsVersions()
    {
        return $this->hasMany('FieldVersion');
    }
}