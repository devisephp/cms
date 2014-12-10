<?php namespace Devise\Pages\Collections;

use Devise\Pages\Fields\FieldValue;

/**
 * This classes purpose is to act as a container
 * for fields on the collection level. A collection
 * can have multiple fields, e.g.
 *
 *     myCollection->field1->someProperty
 *     myCollection->field2->someProperty
 *
 * We hydrate all the fields on construction of this
 * object. If a field is not found on this collection
 * fields object then a generic FieldValue({}) is returned
 * so that we don't run into NullPointerExceptions
 */
class CollectionFields
{
    /**
     * Create a new collection fields object
     * from an array of fields
     *
     * @param array $fields
     */
    public function __construct($fields)
    {
        $this->hydrate($fields);
    }

    /**
     * Loop over the array of fields and
     * assign each field's key as the key
     * that we will use to access that field's
     * values on this collection fields object.
     *
     * @param  Field $fields
     * @return void
     */
    protected function hydrate($fields)
    {
        foreach ($fields as $field)
        {
            $this->{$field->key} = $field->values;
        }
    }

    /**
     * This magic method is used whenever we
     * attempt to access a field key that doesn't
     * exist on this CollectionFields container
     * so that we don't return null (in case that
     * we are chaining things)
     *
     * @param  string $name
     * @return FieldValue
     */
    public function __get($name)
    {
        return new FieldValue('{}');
    }
}