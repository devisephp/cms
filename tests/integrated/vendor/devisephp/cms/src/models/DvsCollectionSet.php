<?php

class DvsCollectionSet extends Eloquent
{
	protected $table = 'dvs_collection_sets';

    protected $guarded = array();

    /**
     * All version of this field
     *
     * @return hasMany
     */
    public function instances()
    {
        return $this->hasMany('DvsCollectionInstance', 'collection_set_id')
                ->orderBy('sort');
    }

    /**
     * All version of this field
     *
     * @return hasMany
     */
    public function fields()
    {
        return $this->hasMany('DvsField', 'collection_set_id');
    }
}