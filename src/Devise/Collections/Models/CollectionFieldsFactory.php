<?php namespace Devise\Collections\Models;

use Field;

class CollectionFieldsFactory
{
    public function __construct(Field $Field)
    {
        $this->Field = $Field;
    }

    public function createFromCollectionInstance($instance)
    {
        $fields = $this->Field->with(['latestPublishedVersion' => function($query) use ($instance)
        {
            $query->where('collection_instance_id','=', $instance->id);
        }])
        ->where('collection_set_id', '=', $instance->collection_set_id)
        ->where('page_id', '=', $instance->page_id)
        ->get();

        return new CollectionFields($fields);
    }

}