<?php namespace Devise\Models\Scaffolding;

use Devise\Models\Scaffolding\Types\CrudScaffolding;

class ScaffoldingManager
{

	/**
	 * The type of scaffolding we are going to make
     *
	 * @var string
	 */
	private $scaffoldingType;

	private $scaffolding;

	public function __construct(CrudScaffolding $CrudScaffolding)
	{
		$this->scaffoldingType = 'crud';
		$this->CrudScaffolding = $CrudScaffolding;
	}

	public function makeScaffolding($input)
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

        $modelName = $this->cleanseString( $input['model_name'] );

        $this->appendSoftDelete($input);

        $this->appendTimestamps($input);

		echo $this->scaffolding->scaffold($modelName, $input['fields']);
	}

	public function setScaffoldingType($type)
	{
		$this->scaffoldingType = $type;
	}

    /**
     * Checks for deleted_at key in input array
     * and appends deleted_at data if it exists
     *
     * @param array  $input
     * @return void
     */
    private function appendSoftDelete(&$input)
    {
        if (in_array('deleted_at', array_keys($input))) {
            $input['fields'][] = [
                'name' => 'deleted_at',
                'type' => 'timestamp',
                'nullable' => true,
                'displayForm' => false
            ];
        }
    }

    /**
     * Checks for timestamps key to determine if created_at
     * and updated_at fields should be added to fields array
     *
     * @param array  $input
     * @return void
     */
    private function appendTimestamps(&$input)
    {
        if (in_array('timestamps', array_keys($input))) {
            $timestampsArr = ['created_at', 'updated_at'];

            foreach($timestampsArr as $timestamp) {
                $input['fields'][] = [
                    'name' => $timestamp,
                    'type' => 'timestamp',
                    'default' => '0000-00-00 00:00:00',
                    'displayForm' => false
                ];
            }
        }
    }

    /**
     * Removes special characters from string
     *
     * @return string
     */
    private function cleanseString($string)
    {
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }
}