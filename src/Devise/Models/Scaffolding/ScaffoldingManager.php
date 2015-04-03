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

        $this->processInputData($input);

		echo $this->scaffolding->scaffold($input['model_name'], $input['fields']);
	}

	public function setScaffoldingType($type)
	{
		$this->scaffoldingType = $type;
	}

    /**
     * Takes in input array and sets/unsets data
     * according to form input.
     *
     * @param  array $input
     * @return array
     */
    private function processInputData(&$input)
    {
        $input = array_except($input, ['_token']);

        $this->cleanseModelName($input);

        $this->appendSoftDelete($input);

        $this->appendTimestamps($input);
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

            unset($input['deleted_at']);
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

            unset($input['timestamps']);
        }
    }

    /**
     * Removes special characters from input['model_name']
     *
     * @return array
     */
    private function cleanseModelName(&$input)
    {
        $input['model_name'] = preg_replace('/[^A-Za-z0-9\-]/', '', $input['model_name']);
    }
}