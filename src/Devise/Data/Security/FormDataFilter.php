<?php namespace Devise\Data\Security;

use App;
use Config;
use Crypt;
use Devise\Support\Helpers\DeviseArray;
use Input;
use Session;
use Request;

class FormDataFilter {
    /**
    * Instance of DeviseArray
    */
    private $optionalTypes = array('checkbox','radio','submit');

    /**
    * Instance of DeviseArray
    */
    private $DeviseArray;

    /**
    * Create an instance of Repository
    */
    public function __construct(DeviseArray $DeviseArray)
    {
        $this->DeviseArray = $DeviseArray;
    }

    /**
     * Create a new model based form builder.
     *
     * @internal param mixed $model
     * @internal param array $options
     * @return string
     */
    public function filter()
    {
        if(Session::has(Request::url())){
            $flatInput = $this->getInputData();
            $flatData = $this->getValidData();

            if($this->doNotMatch($flatInput, $flatData)){
                if (Config::get('app.debug')) {
                    App::abort(403, 'Unauthorized action. Debug: This is most likely due to a form being misconfigured. Did you copy and paste a form element? Did you remember Form::close()?');
                }
                App::abort(403, 'Unauthorized action.');
            }
        }
    }

    private function getInputData()
    {
        $data = $this->DeviseArray->flattenArray(Input::all(), array(),'.',':', false);
        return $data;
    }

    private function getValidData()
    {
        $data = explode('||', Crypt::decrypt(Session::get(Request::url())));
        return $data;
    }

    private function doNotMatch($inputItems, $validItems)
    {
        $urlIsValid = $this->validURL(array_shift($validItems));
        $dataIsValid = $this->validData($inputItems, $validItems);

        return (!$urlIsValid || !$dataIsValid);
    }

    private function validURL($validURL)
    {
        return (Request::url() == $validURL);
    }

    /**
     * Create a new model based form builder.
     *
     * @param $inputItems
     * @param $validItems
     * @internal param mixed $model
     * @internal param array $options
     * @return string
     */
    private function validData($inputItems, $validItems)
    {
        if(count($inputItems) <= count($validItems)){
            rsort($inputItems);
            rsort($validItems);

            $amnt = count($inputItems);
            $j = 0;
            for ($i = 0; $i < $amnt; $i++) {
                if($j >= count($validItems)) return false;

                $inputObj = $this->parseInputItem($inputItems[ $i ]);
                $validObj = $this->parseValidItem($validItems[ $j ]);

                if(!$this->validInput($inputObj, $validObj)){
                    if(in_array($validObj['type'], $this->optionalTypes)){
                        $i--;
                        $j++;

                        continue;
                    }

                    return false;
                }

                $j++;
            }
            return true;
        } else {
            return false;
        }
    }

    private function parseInputItem($item)
    {
        $parts = explode(':', $item);
        $item = array(
            'name' => $parts[0]
        );

        if(count($parts) > 1){
            $item['value'] = $parts[1];
        }

        return $item;
    }

    private function parseValidItem($item)
    {
        $parts = explode(':', $item);
        $item = array(
            'name' => $parts[0],
            'type' => $parts[1]
        );

        if(count($parts) > 2){
            $item['value'] = $parts[1];
            $item['type'] = $parts[2];
        }

        return $item;
    }

    /**
     * Compares post data to the _data_token values
     *
     * @param  string  $one
     * @param  string  $two
     * @return boolean
     */
    private function validInput($inputObj, $validObj)
    {
        if($validObj['type'] == 'secure'){
            return ($inputObj['name'] == $validObj['name'] && $inputObj['value'] == $validObj['value']);
        } else {
            return ($inputObj['name'] == $validObj['name']);
        }
    }
}
