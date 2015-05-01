<?php

class DvsCollectionInstance extends Eloquent
{
	protected $table = 'dvs_collection_instances';

    protected $guarded = array();

    /**
     * Collection instances belong to CollectionSet
     *
     * @return belongsTo
     */
    public function collectionSet()
    {
        return $this->belongsTo('DvsCollectionSet', 'collection_set_id');
    }

    /**
     * All collection instances has many fields
     *
     * @return hasMany
     */
    public function fields()
    {
        return $this->hasMany('DvsField', 'collection_instance_id');
    }
}