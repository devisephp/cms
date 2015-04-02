<?php namespace Devise\Models\Scaffolding;

use Devise\Support\Framework;

class SanityChecksHelper {

	public function __construct(Framework $Framework)
	{
		$this->Framework = $Framework;
	}

	public function runSanityCheck($constants, $viewFiles, $srcFiles)
	{
		$this->constants = $constants;	
		$this->viewFiles = $viewFiles;	
		$this->srcFiles  = $srcFiles;	

		$checks = [
			$this->checkViewsDirectory(),
			$this->checkSrcDirectory(),
		];

		if(!in_array(false, $checks)) {
			return true;
		}

		return false;
	}


	protected function checkViewsDirectory()
	{
		$path = base_path() . '/resources/views/admin/' . $this->constants['viewsDirectory'];

		return $this->checkDirectoryAndFileStatus($path, $this->viewFiles);
	}

	protected function checkSrcDirectory() 
	{
		$path = app_path() . '/' . $this->constants['srcDirectory'];

		return $this->checkDirectoryAndFileStatus($path, $this->srcFiles);
	}

	protected function checkDirectoryAndFileStatus($path, $files) 
	{
		if (!$this->Framework->File->isDirectory($path)) {

			// Directory doesn't exist so let's make it
			return $this->Framework->File->makeDirectory($path, $mode = 0766, $recursive = true);

		}

		return true;
	}
}