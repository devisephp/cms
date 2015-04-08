<?php namespace Devise\Models\Scaffolding;

use Mockery as m;

class ScaffoldingManagerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $TemplateScaffolding = m::mock('Devise\Models\Scaffolding\TemplateScaffolding');
        $SeederScaffolding = m::mock('Devise\Models\Scaffolding\SeederScaffolding');
        $SanityChecksHelper = m::mock('Devise\Models\Scaffolding\SanityChecksHelper');
        $MigrationScaffolding = m::mock('Devise\Models\Scaffolding\MigrationScaffolding');
        $DeviseSeeder = m::mock('Devise\Support\DeviseSeeder');

        $Framework = new \Devise\Support\Framework;
        $this->CrudScaffolding = new \Devise\Models\Scaffolding\Types\CrudScaffolding(
            $TemplateScaffolding,
            $SanityChecksHelper,
            $MigrationScaffolding,
            $SeederScaffolding,
            $DeviseSeeder,
            $Framework
        );
        $this->ScaffoldingManager = new \Devise\Models\Scaffolding\ScaffoldingManager($this->CrudScaffolding);

        $this->input = [
          "_token" => 'asdfasdfasdf',  
          "model_name" => "Testing",
          "timestamps" => "on",
          "deleted_at" => "on",
          "fields" => [
            0 => [
              "name" => "id",
              "type" => "increments",
              "label" => "Id",
              "formType" => "",
              "displayForm" => "off",
              "displayIndex" => "on",
              "index" => "index",
            ],
            1 => [
              "name" => "name",
              "type" => "string",
              "label" => "Name",
              "default" => "Gary",
              "formType" => "",
              "displayForm" => "on",
              "displayIndex" => "on",
              "nullable" => "off"
            ]
          ]
        ];
    }

    public function test_ensure_interpret_removes_token()
    {
        $this->ScaffoldingManager->interpretInputData($this->input);
        
        assertFalse(isset($this->input['_token']));
        assertEquals($this->input['model_name'], 'Testing');
        
    }

    public function test_ensure_interpret_makes_timestamps()
    {
        $this->ScaffoldingManager->interpretInputData($this->input);
        
        assertEquals(count($this->input['fields']), 5);
        assertTrue(isset($this->input['fields'][4]));
        assertEquals($this->input['fields'][3]['name'], 'created_at');
        assertEquals($this->input['fields'][4]['name'], 'updated_at');
    }

    public function test_ensure_interpret_doesnt_make_timestamps()
    {
        unset($this->input['timestamps']);
        $this->ScaffoldingManager->interpretInputData($this->input);
        
        assertEquals(count($this->input['fields']), 3);
        assertTrue(!isset($this->input['fields'][4]));
    }

    public function test_ensure_interpret_makes_deleted_at()
    {
        $this->ScaffoldingManager->interpretInputData($this->input);
        
        assertEquals(count($this->input['fields']), 5);
        assertTrue(isset($this->input['fields'][4]));
        assertEquals($this->input['fields'][2]['name'], 'deleted_at');
    }

    public function test_ensure_interpret_doesnt_make_deleted_at()
    {
        unset($this->input['deleted_at']);
        $this->ScaffoldingManager->interpretInputData($this->input);
        
        assertEquals(count($this->input['fields']), 4);
        assertNotEquals($this->input['fields'][2]['name'], 'deleted_at');
    }


}