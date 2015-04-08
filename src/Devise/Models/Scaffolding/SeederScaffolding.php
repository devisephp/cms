<?php namespace Devise\Models\Scaffolding;

use Devise\Support\Framework;
use \Artisan;
use \Schema;


class SeederScaffolding {

	protected $constants;

	protected $fields;

	public function __construct(Framework $Framework)
	{
		$this->Framework = $Framework;
	}

	public function buildAndRun($constants)
	{
		$this->constants = $constants;

		if($this->buildAllSeeders()) {
			$this->runSeeds();
		}

		return false;
	}


	public function runSeeds()
	{
		return Artisan::call('db:seed --class="'. $this->constants['snakeCasePlural'] .'Seeder');
	}


	public function getTemplatePath()
	{
		return base_path() . '/vendor/devisephp/cms/src/scaffolding/'. $this->constants['scaffoldingType'] .'/seeds';
	}


	public function getTargetFilePath($templateFile)
	{
		$nameOfFile = $this->Framework->File->name($templateFile);
		return base_path() . '/database/seeds/' . $this->constants['modelName'] . $nameOfFile . '.php';
	}


	public function saveSeed($targetFile, $template)
	{
		return $this->Framework->File->put($targetFile, $template);
	}

	private function buildAllSeeders()
	{
		$templateFilePath = $this->getTemplatePath();
		$files = $this->Framework->File->files($templateFilePath);

		foreach($files as $file) {
			$this->buildSeeder($file);
		}
	}


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