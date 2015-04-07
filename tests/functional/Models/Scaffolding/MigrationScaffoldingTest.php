<?php namespace Devise\Models\Scaffolding;

use Mockery as m;

class MigrationScaffoldingTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $Framework = new \Devise\Support\Framework;
        $this->MigrationScaffolding = new MigrationScaffolding($Framework);
        $this->MockMigrationScaffolding = m::mock('Devise\Models\Scaffolding\MigrationScaffolding[runMigration, getMigrationTemplatePath]', [$Framework]);

        $this->constants = [
			'original'        => "little Widget",
			'singular'        => "little widget",
			'singularCase'    => "Little Widget",
			'plural'          => "little widgets",
			'pluralCase'      => "Little Widgets",
			'snakeCase'       => "little_widget",
			'snakeCasePlural' => "little_widgets",
			'camelCase'       => "littleWidget",
			'camelCasePlural' => "littleWidgets",
			'viewsDirectory'  => "little_widgets",
			'srcDirectory'    => "LittleWidgets",
			'modelName'       => "LittleWidget",
			'className'       => "LittleWidgets",
			'slug'            => "little-widgets",
			'singularVar'     => "littleWidget",
			'pluralVar'       => "littleWidgets"
		];

		$this->fields = [
			[
				'name' => 'id',
				'type' => 'increments',
				'index' => 'index',
				'displayForm' => false,
				'displayIndex' => true,
			],
			[
				'name' => 'title',
				'type' => ['string', 100],
				'label' => 'The Title Of It All!',
				'options' => ['class' => 'whatever'],
				'displayIndex' => true
			],
			[
				'name' => 'author_of_the_article',
				'type' => 'string',
				'choices' => ['jimmy' => 'Jimmy', 'sarah' => 'Sarah'],
				'formType' => 'select',
				'displayIndex' => true
			],
			[
				'name' => 'deleted_at',
				'type' => 'timestamp',
				'nullable' => true,
				'displayForm' => false
			],
			[
				'name' => 'created_at',
				'type' => 'timestamp',
				'default' => '0000-00-00 00:00:00',
				'displayForm' => false
			],
			[
				'name' => 'updated_at',
				'type' => 'timestamp',
				'default' => '0000-00-00 00:00:00',
				'displayForm' => false
			]
		];
    }

    public function test_it_doesnt_create_table_if_it_exists()
    {
    	$this->constants['snakeCasePlural'] = 'users';
       	$result = $this->MigrationScaffolding->buildAndRun($this->constants, $this->fields);
        assertFalse($result);
    }

    public function test_it_creates_table_if_table_doesnt_exist()
    {
    	$this->MockMigrationScaffolding->shouldReceive('runMigration')->times(1)->andReturn(true);

    	$this->MockMigrationScaffolding->shouldReceive('getMigrationTemplatePath')->times(1)->andReturn('src/scaffolding/migrations/create_model.txt');

       	$result = $this->MockMigrationScaffolding->buildAndRun($this->constants, $this->fields);
        assertTrue($result);
    }
}