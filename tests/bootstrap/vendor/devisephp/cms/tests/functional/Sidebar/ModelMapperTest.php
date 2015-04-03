<?php namespace Devise\Sidebar;

use Mockery as m;

class ModelMapperTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $DvsModelField = new \DvsModelField;
        $DvsPageVersion = new \DvsPageVersion;
        $Framework = new \Devise\Support\Framework;

        $this->ModelMapper = new ModelMapper($DvsModelField, $Framework, $DvsPageVersion);
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

    public function test_it_can_create_model()
    {
        $forms = [
            'Name' => [ 'text' => 'Kelt' ],
            'Email' => [ 'text' => 'kelt@lbm.co' ],
            'Password' => [ 'text' => 'testing' ],
        ];

        $model = $this->ModelMapper->create('DvsUser', $pageVersionId = 1, $forms);

        assertInstanceOf('DvsUser', $model);
    }

    public function test_it_cannot_create_invalid_model()
    {
        // make sure field count is same before and after
        // we attempt to create an invalid model
        //
        // $forms = [
        //     'Name' => [ 'text' => 'Kelt' ],
        //     'Email' => [ 'text' => 'kelt@lbm.co' ],
        // ];

        // $model = $this->ModelMapper->create('DvsUser', $pageVersionId = 1, $forms);

        // dd($model->toArray());
    }

    public function test_it_can_update_model()
    {
        $this->createModelField(['id' => 1, 'model_id' => 1, 'model_type' => 'DvsUser', 'mapping' => 'Name']);
        $this->createModelField(['id' => 2, 'model_id' => 1, 'model_type' => 'DvsUser', 'mapping' => 'Email']);
        $this->createModelField(['id' => 3, 'model_id' => 1, 'model_type' => 'DvsUser', 'mapping' => 'Password']);

        $forms = [
            'Name' => [ 'text' => 'Kelt' ],
            'Email' => [ 'text' => 'kelt@lbm.co' ],
            'Password' => [ 'text' => 'testing' ],
        ];

        $model = $this->ModelMapper->update('DvsUser', $id = 1, $pageVersionId = 1, $forms);

        assertEquals('Kelt', $model->name);
        assertEquals('kelt@lbm.co', $model->email);
    }

    private function createModelField($attributes)
    {
        $attributes['json_value'] = isset($attributes['json_value']) ? $attributes['json_value'] : '{}';

        $DvsModelField = new \DvsModelField;

        foreach ($attributes as $attribute => $value)
        {
            $DvsModelField->$attribute = $value;
        }

        $DvsModelField->save();

        return $DvsModelField;
    }
}