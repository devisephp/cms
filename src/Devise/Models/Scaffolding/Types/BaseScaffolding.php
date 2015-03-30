<?php namespace Devise\Models\Scaffolding\Types;

use Devise\Support\Framework;

class BaseScaffolding
{
	public $constants;

	public $viewFiles;

	public $srcFiles;

	public function __construct(Framework $Framework)
	{
		$this->Framework = $Framework;
		$this->viewFiles = [];
		$this->srcFiles = [];
	}

	public function scaffold($modelName)
	{
		// Make View Files from templates
		// Make App Src Files from templates
		// Create Templates in Devise
		// Create Pages in Devise
		// Create APIs in Devise
		
		$this->hydrateConstants($modelName);
		$this->setViewFiles();

		if ($this->runSanityCheck()) {
			
			$this->makeViewFiles();

			return true;

		} else {
			return false;
		}
	}

	protected function hydrateConstants($modelName)
	{
		$this->constants = [
			'original'  => $modelName,
			'singular'  => str_singular($modelName),
			'plural'    => str_plural($modelName),
			'snakeCase' => snake_case($modelName),
			'camelCase' => camel_case($modelName)
		];
	}

	protected function runSanityCheck()
	{
		$checks = [
			$this->checkViewsDirectory(),
			$this->checkSrcDirectory(),
		];

		if(!in_array(false, $checks)) {
			return true;
		}

		return false;
	}

	protected function setViewFiles() {}

	protected function checkViewsDirectory()
	{
		$path = base_path() . '/resources/views/admin/' . $this->constants['snakeCase'];

		return $this->checkDirectoryAndFileStatus($path, $this->viewFiles);
	}

	protected function checkSrcDirectory() 
	{
		$path = app_path() . '/' . $this->constants['camelCase'];

		return $this->checkDirectoryAndFileStatus($path, $this->srcFiles);
	}

	protected function checkDirectoryAndFileStatus($path, $files) 
	{
		if (!$this->Framework->File->isDirectory($path)) {

			// Directory doesn't exist so let's make it
			return $this->Framework->File->makeDirectory($path,  $mode = 0766, $recursive = true);

		} else {
			// Check to see if any of the view files
			// are already present. If they are return 
			// false and bomb out.
			foreach ($files as $template => $file) {

				if ($this->Framework->File->isFile($file)) {
					return false;
				}
			}
		}

		return true;
	}


	protected function makeViewFiles() 
	{
		$path = base_path() . '/resources/views/admin/' . $this->constants['snakeCase'];

		return $this->convertTemplatesAndSave($path, $this->viewFiles);
	}

	protected function convertTemplatesAndSave($path, $files)
	{
		foreach ($files as $template => $file) {
			$template = $this->Framework->File->get($template);

			foreach($this->constants as $key => $value) {
				$template = str_replace('*|'.$key.'|*', $value, $template);
			}

			$this->Framework->File->put($file, $template);
		}

		return true;
	}

}