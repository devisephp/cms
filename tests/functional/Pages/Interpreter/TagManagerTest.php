<?php namespace Devise\Pages\Interpreter;

use Mockery as m;

class TagManagerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->DvsField =  new \DvsField;
        $this->DvsGlobalField =  new \DvsGlobalField;
        $this->DvsCollectionSet =  new \DvsCollectionSet;
        $this->DvsModelField =  new \DvsModelField;
        $this->CollectionsRepository = m::mock('Devise\Pages\Collections\CollectionsRepository');
        $this->TagManager = new TagManager($this->DvsField, $this->DvsGlobalField, $this->DvsCollectionSet, $this->DvsModelField, $this->CollectionsRepository);
    }

    public function test_it_can_be_initialized()
    {
        $this->TagManager->initialize(1, 1, 45);
    }

    public function test_it_can_get_instance_for_field_tag()
    {
        $tag = ['bindingType' => 'field', 'key' => 'somekey', 'type' => 'text', 'humanName' => 'human name', 'defaults' => null];
        $this->TagManager->initialize(1, 1, 45);
        $outcome = $this->TagManager->getInstanceForTag($tag);
        assertEquals(null, $outcome->collection_instance_id);
        assertEquals(1, $outcome->page_version_id);
        assertEquals("text", $outcome->type);
        assertEquals("human name", $outcome->human_name);
        assertEquals("somekey", $outcome->key);
        assertEquals("{}", $outcome->json_value);
        assertEquals(false, $outcome->content_requested);
        assertEquals("field", $outcome->scope);
    }

    public function test_it_can_get_instance_for_collection_tag()
    {
        $tag = ['bindingType' => 'collection', 'collection' => 'collectionName'];
        $this->TagManager->initialize(1, 1, 45);
        $outcome = $this->TagManager->getInstanceForTag($tag);
        assertEquals($outcome->name, 'collectionName');
    }

    public function test_it_can_get_instance_for_model_tag()
    {
        $tag = ['bindingType' => 'model', 'key' => 1, 'type' => 'DvsTestModel', ];
        $this->TagManager->initialize(1, 1, 45);
        $outcome = $this->TagManager->getInstanceForTag($tag);
        assertEquals("1", $outcome[0]->model_id);
        assertEquals("DvsTestModel", $outcome[0]->model_type);
        assertEquals("Name", $outcome[0]->mapping);
        assertEquals("{}", $outcome[0]->json_value);
    }

    public function test_it_can_get_instance_for_attribute_tag()
    {
        $tag = ['bindingType' => 'attribute', 'key' => 1, 'type' => 'DvsTestModel', 'attribute' => 'name'];
        $this->TagManager->initialize(1, 1, 45);
        $outcome = $this->TagManager->getInstanceForTag($tag);
        assertEquals("1", $outcome->model_id);
        assertEquals("DvsTestModel", $outcome->model_type);
        assertEquals("Name", $outcome->mapping);
        assertEquals("{}", $outcome->json_value);
    }

    public function test_it_can_get_instance_for_creator_tag()
    {
        $tag = ['bindingType' => 'creator', 'id' => 'some id', 'key' => 'DvsTestModel', 'defaults' => null];
        $this->TagManager->initialize(1, 1, 45);
        $outcome = $this->TagManager->getInstanceForTag($tag);
        assertEquals('some id', $outcome->id);
        assertEquals('DvsTestModel', $outcome->model_type);
        assertEquals(['Name' => ['name' => 'text']], $outcome->picks);
        assertEquals(['page_version_id' => 'required', 'name' => 'required'], $outcome->rules);
        assertEquals(['Name' => 'text'], $outcome->types);
    }
}