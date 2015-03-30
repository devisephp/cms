<?php namespace Devise\Models\Scaffolding\Types;

use Devise\Support\Framework;

class CrudScaffolding extends BaseScaffolding
{

	public function __construct(Framework $Framework)
	{
		parent::__construct($Framework);
	}

	protected function setViewFiles()
	{
		$scaffoldSrcBase = base_path() . '/vendor/devisephp/cms/src/views/scaffolding/crud/';

		$viewBase = base_path() . '/resources/views/admin/' . $this->constants['snakeCase'] . '/';

		$this->viewFiles = [
			$scaffoldSrcBase . 'admin/_form-fields.txt' 
				=> $viewBase . '_form-fields.blade.php',
			$scaffoldSrcBase . 'admin/create.txt' 
				=> $viewBase . 'create.blade.php',
			$scaffoldSrcBase . 'admin/edit.txt' 	
				=> $viewBase . 'edit.blade.php',
			$scaffoldSrcBase . 'admin/index.txt' 
				=> $viewBase . 'index.blade.php',
		];
	}

}