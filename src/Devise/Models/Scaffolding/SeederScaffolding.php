<?php namespace Devise\Models\Scaffolding;

use Devise\Support\Framework;
use \Artisan;
use \Schema;


/**
 * Class SeederScaffolding
 * @package Devise\Models\Scaffolding
 */
class SeederScaffolding {

	/**
	 * @var
     */
	protected $constants;

	/**
	 * @var
     */
	protected $fields;

	/**
	 * @param Framework $Framework
     */
	public function __construct(Framework $Framework)
	{
		$this->Framework = $Framework;
	}

	/**
	 * @param $constants
	 * @return bool
     */
	public function buildAndRun($constants)
	{
		$this->constants = $constants;

		if($this->buildAllSeeders()) {
			$this->injectInDatabaseSeeder();
			$this->runSeeds();
		}

		return false;
	}
	
	/**
	 * @return mixed
     */
	public function runSeeds()
	{
		return Artisan::call('db:seed --class="'. $this->constants['snakeCasePlural'] .'Seeder');
	}

	/**
	 * @return string
     */
	public function getTemplatePath()
	{
		return base_path() . '/vendor/devisephp/cms/src/scaffolding/'. $this->constants['scaffoldingType'] .'/seeds';
	}

	/**
	 * @return string
     */
	public function getDatabaseSeederPath()
	{
		return base_path() . '/database/seeds/DatabaseSeeder.php';
	}

	/**
	 * @param $templateFile
	 * @return string
     */
	public function getTargetFilePath($templateFile)
	{
		$nameOfFile = $this->Framework->File->name($templateFile);
		return base_path() . '/database/seeds/' . $this->constants['modelName'] . $nameOfFile . '.php';
	}


	/**
	 * @param $targetFile
	 * @param $template
	 * @return mixed
     */
	public function saveSeed($targetFile, $template)
	{
		return $this->Framework->File->put($targetFile, $template);
	}

	/**
	 *
     */
	private function buildAllSeeders()
	{
		$templateFilePath = $this->getTemplatePath();
		$files = $this->Framework->File->files($templateFilePath);

		foreach($files as $file) {
			$this->buildSeeder($file);
		}
	}

	/**
	 *
     */
	private function injectInDatabaseSeeder()
	{
		$databaseSeederFilePath = $this->getDatabaseSeederPath();
		$databaseSeederfile = $this->Framework->File->get($databaseSeederFilePath);

		$start = strpos($databaseSeederfile, "run()");
	}


	/**
	 * @param $templateFile
	 * @return mixed
     */
	private function buildSeeder($templateFile)
	{
		$targetFile = $this->getTargetFilePath($templateFile);

		$template = $this->Framework->File->get($templateFile);

		foreach($this->constants as $key => $value) {
			$template = str_replace('*|'.$key.'|*', $value, $template);
		}

		return $this->saveSeed($targetFile, $template);
	}
}