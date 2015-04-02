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

		$fields = [
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

		echo $this->scaffolding->scaffold('Little Widget', $fields);
	}

	public function setScaffoldingType($type)
	{
		$this->scaffoldingType = $type;
	}
}