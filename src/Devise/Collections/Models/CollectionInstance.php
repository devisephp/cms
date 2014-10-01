<?php

class CollectionInstance extends Eloquent
{
	protected $table = 'dvs_collection_instance';

    protected $guarded = array();

    /**
     * Collection instances belong to CollectionSet
     *
     * @return belongsTo
     */
    public function collectionSet()
    {
        return $this->belongsTo('CollectionSet');
    }

    /**
     * All collection instances has many fields
     *
     * @return hasMany
     */
    public function fields()
    {
        return $this->hasMany('Field', 'collection_instance_id');
    }
}