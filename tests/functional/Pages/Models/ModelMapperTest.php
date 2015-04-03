<?php namespace Devise\Pages\Models;

use Mockery as m;

class ModelMapperTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $DvsModelField = new \DvsModelField;
        $Framework = new \Devise\Support\Framework;

        $this->ModelMapper = new ModelMapper($DvsModelField, $Framework);
    }

    public function test_it_can_lookup_mapping_with_a_key()
    {
        $map = $this->ModelMapper->lookupWithKey('DvsUser', $id = 1);

        assertObjectHasAttribute('model', $map);

        assertCount(3, $map->rules);
        assertEquals('DvsUser', $map->class_name);
        assertEquals(1, $map->key);

        assertCount(3, $map->fields);
        assertObjectHasAttribute('dvs_model_field', $map->fields[0]);
        assertObjectHasAttribute('cid', $map->fields[0]);
        assertObjectHasAttribute('alias', $map->fields[0]);
        assertObjectHasAttribute('type', $map->fields[0]);
        assertObjectHasAttribute('picks', $map->fields[0]);
    }

    public function test_it_can_lookup_mapping_without_key()
    {
        $map = $this->ModelMapper->lookupWithoutKey('DvsUser');

        assertCount(3, $map->rules);
        assertEquals('DvsUser', $map->class_name);
        assertEquals(null, $map->key);

        assertCount(3, $map->fields);
        assertObjectHasAttribute('dvs_model_field', $map->fields[0]);
        assertObjectHasAttribute('cid', $map->fields[0]);
        assertObjectHasAttribute('alias', $map->fields[0]);
        assertObjectHasAttribute('type', $map->fields[0]);
        assertObjectHasAttribute('picks', $map->fields[0]);
    }
}