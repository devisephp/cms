<?php namespace Devise\Pages\Collections;

class CollectionFieldsTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->CollectionFields = new CollectionFields(array());
    }

    public function test_it_can_get_field_values()
    {
        assertInstanceOf('Devise\Pages\Fields\FieldValue', $this->CollectionFields->doesnotexists);
    }
}