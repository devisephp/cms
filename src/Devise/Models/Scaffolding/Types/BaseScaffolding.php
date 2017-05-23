<?php namespace Devise\Models\Scaffolding\Types;

use Devise\Support\Framework;
use Devise\Models\Scaffolding\TemplateScaffolding;
use Devise\Models\Scaffolding\SanityChecksHelper;
use Devise\Models\Scaffolding\MigrationScaffolding;
use Devise\Models\Scaffolding\SeederScaffolding;
use Devise\Support\DeviseSeeder;

/**
 * Class BaseScaffolding
 * @package Devise\Models\Scaffolding\Types
 */
class BaseScaffolding
{

	/**
	 * @var
     */
	public $constants;

	/**
	 * @var array
     */
	public $viewFiles;

	/**
	 * @var array
     */
	public $templates;

	/**
	 * @var array
     */
	public $srcFiles;

	/**
	 * @var array
     */
	public $pages;

	/**
	 * @var array
     */
	public $apis;

	/**
	 * @var
     */
	protected $fields;

	/**
	 * @param TemplateScaffolding $TemplateScaffolding
	 * @param SanityChecksHelper $SanityChecksHelper
	 * @param MigrationScaffolding $MigrationScaffolding
	 * @param SeederScaffolding $SeederScaffolding
	 * @param Framework $Framework
     */
	public function __construct(
		TemplateScaffolding $TemplateScaffolding,
		SanityChecksHelper $SanityChecksHelper,
		MigrationScaffolding $MigrationScaffolding,
		SeederScaffolding $SeederScaffolding,
		DeviseSeeder $DeviseSeeder,
		Framework $Framework
	) {
		$this->TemplateScaffolding   = $TemplateScaffolding;
		$this->SanityChecksHelper    = $SanityChecksHelper;
		$this->MigrationScaffolding  = $MigrationScaffolding;
		$this->SeederScaffolding     = $SeederScaffolding;
		$this->Seeder                = $DeviseSeeder;
		$this->Framework             = $Framework;
		$this->viewFiles             = [];
		$this->templates             = [];
		$this->srcFiles              = [];
		$this->pages                 = [];
		$this->apis                  = [];
	}

	/**
	 * @param $modelName
	 * @param array $fields
	 * @return bool
     */
	public function scaffold($modelName, $fields = [])
	{
		$this->fields = $fields;

		$this->hydrateConstants($modelName);
		$this->setViewFiles();
		$this->setSrcFiles();
		$this->setPages();
		$this->setApis();

		$this->extendConstansts($modelName);

		if ($this->SanityChecksHelper->runSanityCheck(
				$this->constants, 
				$this->viewFiles, 
				$this->srcFiles
			)) {

			// Make View Files from templates
			$this->makeViewFiles();

			// Make App Src Files from templates
			$this->makeSrcFiles();

			// Build and run the migration for the new model
			$this->MigrationScaffolding->buildAndRun($this->constants, $this->fields);

			// Insert template configuration in Devise templates.php config
			$this->TemplateScaffolding->insertTemplateConfiguration($this->viewFiles);

			// Build it and run it
			$this->SeederScaffolding->build($this->constants);

			// Create Pages in Database
			$this->createPages($this->pages);

			// Create APIs in Database
			$this->createPages($this->apis);

			return true;

		} else {
			return false;
		}
	}

	/**
	 * @param $modelName
     */
	protected function hydrateConstants($modelName)
	{
		$englishConstants = [
			
			'original'        => $modelName, //little Widget
			'singular'        => strtolower(str_singular($modelName)), // little widget
			'singularCase'    => ucwords(str_singular($modelName)), // Little Widget
			'plural'          => strtolower(str_plural($modelName)), // little widgets
			'pluralCase'      => ucwords(str_plural($modelName)), // Little Widgets
		];

		$modelName = htmlspecialchars($modelName);
		$modelName = str_replace(' ', '_', $modelName);

		$codeConstants = [
			'snakeCase'       => snake_case(str_singular($modelName)), // little_widget
			'snakeCasePlural' => snake_case(str_plural($modelName)), // little_widgets
			'camelCase'       => camel_case(str_singular($modelName)), // littleWidget
			'camelCasePlural' => camel_case(str_plural($modelName)), // littleWidgets
			'viewsDirectory'  => snake_case(str_plural($modelName)), // little_widgets
			'srcDirectory'    => ucfirst(camel_case(str_plural($modelName))), // LittleWidgets
			'modelName'       => ucfirst(camel_case(str_singular($modelName))), // LittleWidget
			'className'       => studly_case(str_plural($modelName)), // LittleWidgets
			'slug'            => str_slug(str_plural($modelName)), //little-widgets
			'singularVar'     => lcfirst(camel_case(str_singular($modelName))), // littleWidget
			'pluralVar'       => lcfirst(camel_case(str_plural($modelName))), // littleWidgets
			'namespace'       => trim($this->Framework->container->getInstance()->getNameSpace(), '\\')
		];

		$this->constants = $englishConstants + $codeConstants;
	}

	/**
	 * @return bool
     */
	protected function makeViewFiles()
	{
		return $this->TemplateScaffolding->convertTemplatesAndSave($this->viewFiles, $this->constants, $this->fields);
	}

	/**
	 * @return bool
     */
	protected function makeSrcFiles()
	{
		return $this->TemplateScaffolding->convertTemplatesAndSave($this->srcFiles, $this->constants, $this->fields);
	}

	/**
	 * @param $pagesOrApis
	 */
	protected function createPages($pagesOrApis)
	{
		$now = date('Y-m-d H:i:s', strtotime('now'));

		foreach($pagesOrApis as $page) {

			$dvsPage = $this->Seeder->findOrCreateRow('dvs_pages', 'route_name', $page);

			$this->Seeder->findOrCreateRow('dvs_page_versions', 'page_id', [
				'page_id'            => $dvsPage->id,
				'created_by_user_id' => 1,
				'name'               => 'Default',
				'starts_at'          => $now,
			]);
		}
	}
}