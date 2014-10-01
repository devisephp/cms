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
        $fields = $this->Field
            ->where('collection_instance_id', '=', $instance->id)
            ->where('page_version_id', '=', $instance->page_version_id)
            ->get();

        return new CollectionFields($fields);
    }

}