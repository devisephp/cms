<?php namespace Devise\Pages\Data;

use App;
use Config;
use Devise\Pages\Exceptions\PagesException;
use Input;
use Route;

class DataBuilder {
    private static $firstView = true;
    private $loadedClasses = array();
    private $data;
    private $DataCrawler;
    private $variableQueue = array();
    private $queue = array();

    public function __construct(DataCrawler $DataCrawler)
    {
        $this->DataCrawler = $DataCrawler;
    }

    /**
    * Injects data from config into the current view
    *
    * @return array
    **/
    public function compile($queue)
    {
        $this->processQueue($queue);

        return $this->data;
    }

    public function addToQueue($name, $value)
    {  
        $this->queue[ $name ] = $value;
    }

    public function setData($data)
    {
        return $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function retrieveSingle($param)
    {
        $value = $this->DataCrawler->extract($this->data, $param);
        if($value !== DataCrawler::PARAM_NOT_FOUND){
            return $value;
        }
        throw new PagesException("Unable to find values for " . $param);
    }

    /**
    * Gets the value of the view variable from config
    *
    * @return array
    **/
    public function getValue($options)
    {
	    if(is_string($options)){
            // no params defined in the config
            try {
                list($classPath, $function) = explode('.', $options);
            } catch (\Exception $e) {
                if (Config::get('app.debug')) {
                    App::abort(403, 'Devise route configuration error. Debug: This is likely due to a configuration error in your view-vars.php configuration file or in the pages table. Ensure any functional routes have the following format: This\Is\My\Namespace\ClassName.methodName');
                }
                App::abort(403, 'Devise route configuration error.');
            }
            $params = array();
        } else {

            //is it a flat variable which contains the value
		    if (isset($options['value'])) {
			    return $options['value'];
		    }

		    // not a flat variable so the params were defined in the config
            try {
                list($classPath, $function) = explode('.', key($options));
            } catch (\Exception $e) {
                if (Config::get('app.debug')) {
                    App::abort(403, 'Devise route configuration error. Debug: This is likely due to a configuration error in your view-vars.php configuration file or in the pages table. Ensure any functional routes have the following format: This\Is\My\Namespace\ClassName.methodName');
                }
                App::abort(403, 'Devise route configuration error.');
            }
            $params = $this->fillParamRequest( reset($options) );
            if(in_array(DataCrawler::PARAM_NOT_FOUND, $params)){
                return DataCrawler::PARAM_NOT_FOUND;
            }
        }

        $classInstance = $this->loadClass($classPath);
        
        return call_user_func_array(array($classInstance, $function) , $params);
    }

    private function processQueue($queue)
    {
        $failures = array();
        foreach ($queue as $varName => $var) {
            $value = $this->getValue($var);
            if($value !== DataCrawler::PARAM_NOT_FOUND){
                $this->data[ $varName ] = $value;
            } else {
                $failures[ $varName ] = $var;
            }
        }

        if(count($failures)){
            if(count($failures) < count($queue)){
                // only some items failed trying again
                $this->processQueue($failures);
            } else {
                $this->fillWithNulls($failures);
                //throw new PagesException("Unable to find values for " . count($failures) . " variable(s): [" . implode(', ', array_keys($failures)) . "]");
            }
        }
    }

    private function fillWithNulls($failures)
    {
        foreach ($failures as $varName => $var) {
            $this->data[ $varName ] = null;
        }
    }

    /**
    * Uses the path from config to load a class
    * if the class is already loaded the instance is returned
    *
    * @return array
    **/
    private function loadClass($path)
    {
        if(!isset($this->loadedClasses[ $path ])){
            $this->loadedClasses[ $path ] = App::make($path);
        }
        
        return $this->loadedClasses[ $path ];
    }

    /**
    * Loops through params in templates config and fills the value of each
    *
    * @return array
    **/
    private function fillParamRequest($paramRequestList)
    {
        $params = array();
        foreach ($paramRequestList  as $key => $param) {
	        if ($key === 'value') {
		        $params[] = $param;
	        } else {
		        $params[] = $this->DataCrawler->extract( $this->data, $param );
	        }
        }
        return $params;
    }
}