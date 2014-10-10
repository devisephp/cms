<?php

class CollectionSet extends Eloquent
{
	protected $table = 'dvs_collection_sets';

    protected $guarded = array();

    protected $_value;

    /**
     * All version of this field
     *
     * @return hasMany
     */
    public function instances()
    {
        return $this->hasMany('CollectionInstance')
                ->orderBy('sort');
    }

    /**
     * All version of this field
     *
     * @return hasMany
     */
    public function fields()
    {
        return $this->hasMany('Field');
    }
}