<?php namespace Devise\Models\Scaffolding;

/**
 * Class ScaffoldingManager
 * @package Devise\Models\Scaffolding
 */
class ScaffoldingManager
{

    public $errors;

    public $message;

	/**
	 * The type of scaffolding we are going to make
     *
	 * @var string
	 */
	private $scaffoldingType;

    /**
     * @var
     */
    private $scaffolding;

    /**
     * @param $input
     * @return bool
     */
    public function makeScaffolding($input, $scaffolding)
	{


        $this->scaffolding = $scaffolding;

        $this->interpretInputData($input);

		return $this->scaffolding->scaffold($input['model_name'], $input['fields']);
	}

    /**
     * Takes in input array and sets/unsets data
     * according to form input.
     *
     * @param  array $input
     * @return array
     */
    public function interpretInputData(&$input)
    {
        $input = array_except($input, ['_token']);

        $this->cleanseModelName($input);

        $this->appendSoftDelete($input);

        $this->appendTimestamps($input);

        $this->interpretFieldsArray($input);

        array_walk_recursive($input, 'self::castToBoolean');
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
                    'default' => '',
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

    /**
     * Fields input array "choices" and builds/formats
     * array as a properly formatted choices array
     *
     * @return array
     */
    private function interpretFieldsArray(&$input)
    {
        foreach ($input['fields'] as $fIndex => $field) {
            if (isset($field['choices'])) {
                foreach($field['choices'] as $cIndex => $choice) {
                    $input['fields'][$fIndex]['choices'][$choice['value']] = $choice['key'];

                    unset($input['fields'][$fIndex]['choices'][$cIndex]);
                }
            }

            if(array_get($field, 'formType') == '') {
                unset($input['fields'][$fIndex]['formType']);
            }

            if(array_get($field, 'default') == '') {
                unset($input['fields'][$fIndex]['default']);
            }

            if(array_get($field, 'label') == '') {
                unset($input['fields'][$fIndex]['label']);
            }
        }
    }

    /**
     * Ensures checkbox values are set as "true" or "false"
     *
     * @param  string &$value
     * @return void
     */
    private function castToBoolean(&$value)
    {
        if ($value == 'on') {
            $value = true;
        } else if ($value == 'off') {
            $value = false;
        }
    }
}