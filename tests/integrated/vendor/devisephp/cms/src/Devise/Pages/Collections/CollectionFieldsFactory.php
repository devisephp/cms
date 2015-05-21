<?php namespace Devise\Pages\Collections;

/**
 * Collection fields are objects that allow
 * us to traverse the keys in that collection.
 * If a collection has 3 keys, key1, key2 and key3
 * and those keys are all image types then we can
 * access the image urls like so $col->key1->image_url
 */
class CollectionFieldsFactory
{
    /**
     * DvsField model to get data from database
     *
     * @var DvsField
     */
    protected $Field;

    /**
     * Create a new factory
     *
     * @param DvsField $Field
     */
    public function __construct(\DvsField $Field)
    {
        $this->Field = $Field;
    }

    /**
     * Creates collection fields object from a collection
     * instance that we pulled from the database (those will
     * have fields associated with them too)
     *
     * @param  CollectionInstance $instance
     * @return CollectionFields
     */
    public function createFromCollectionInstance($instance)
    {
        $fields = $this->Field
            ->where('collection_instance_id', '=', $instance->id)
            ->where('page_version_id', '=', $instance->page_version_id)
            ->get();

        return new CollectionFields($fields);
    }
}