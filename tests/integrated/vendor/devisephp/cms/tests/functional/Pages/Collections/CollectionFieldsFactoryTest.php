<?php namespace Devise\Pages\Collections;

use Mockery as m;

class CollectionFieldsFactoryTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->CollectionFieldFactory = new CollectionFieldsFactory(new \DvsField);
    }

    public function test_it_creates_collection_fields_from_an_instance()
    {
        $instance = \DvsCollectionInstance::find(1);
        $output = $this->CollectionFieldFactory->createFromCollectionInstance($instance);
        assertEquals('awesome', $output->key1->bar);
    }

}