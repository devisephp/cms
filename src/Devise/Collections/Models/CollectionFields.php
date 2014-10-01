<?php namespace Devise\Collections\Models;

use Devise\Fields\Models\FieldValue;

class CollectionFields
{
    public function __construct($fields)
    {
        $this->hydrate($fields);
    }

    protected function hydrate($fields)
    {
        foreach ($fields as $field)
        {
            $this->{$field->key} = $field->values;
        }
    }

    public function __get($name)
    {
        return new FieldValue('{}');
    }
}