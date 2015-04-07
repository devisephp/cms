<?php namespace Devise\Models\Scaffolding;

use Mockery as m;

class ApiPagesManagerTest extends \DeviseTestCase
{
    public function setUp()
    {
        parent::setUp();

        $Framework = new \Devise\Support\Framework;
        $this->MigrationScaffolding = new MigrationScaffolding($Framework);

        $this->constants = [
			'original'        => "little Widget"
			'singular'        => "little widget"
			'singularCase'    => "Little Widget"
			'plural'          => "little widgets"
			'pluralCase'      => "Little Widgets"
			'snakeCase'       => "little_widget"
			'snakeCasePlural' => "little_widgets"
			'camelCase'       => "littleWidget"
			'camelCasePlural' => "littleWidgets"
			'viewsDirectory'  => "little_widgets"
			'srcDirectory'    => "LittleWidgets"
			'modelName'       => "LittleWidget"
			'className'       => "LittleWidgets"
			'slug'            => "little-widgets"
			'singularVar'     => "littleWidget"
			'pluralVar'       => "littleWidgets"
			'namespace'       => trim($this->getAppNamespace(), '\\')
		];

		$this->fields = [

		]
    }

    public function test_it_doesnt_create_table_if_it_exists()
    {
       	$result = $this->MigrationScaffolding->buildAndRun($this->constants, )
        assertFalse($page->title, 'Some page title');
    }
}