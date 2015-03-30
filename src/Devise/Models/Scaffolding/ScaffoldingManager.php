<?php namespace Devise\Models\Scaffolding;

use Devise\Models\Scaffolding\Types\CrudScaffolding;

class ScaffoldingManager
{

	/**
	 * The type of scaffolding we are going to make
	 * @var string
	 */
	private $scaffoldingType;

	private $scaffolding;

	public function __construct(CrudScaffolding $CrudScaffolding)
	{
		$this->scaffoldingType = 'crud';
		$this->CrudScaffolding = $CrudScaffolding;
	}

	public function makeScaffolding()
	{
		switch($this->scaffoldingType)
		{
			default:
				$this->scaffolding = $this->CrudScaffolding;
			break;
		}

		echo $this->scaffolding->scaffold('Cars');
	}

	public function setScaffoldingType($type)
	{
		$this->scaffoldingType = $type;
	}
}