<?php namespace Devise\Pages\Viewvars;

/**
 *  This builds the variables that are found in views.php config
 *  for a devise page. It uses a ViewComposer (found in this directory)
 *  to inject in the data that is built using this class.
 */
class DataBuilder
{
    /**
     * Keep up with classes that have been loaded
     * so we don't attempt to load them again using App::make
     *
     * @var array
     */
    private $loadedClasses = array();

    /**
     * The data that is for the view
     *
     * @var array
     */
    private $data;

    /**
     * The data crawler uses dot notation to transform
     * a string Namespaced\Class\Path.methodName from
     * the views into a proper class and method name
     * we can execute
     *
     * @var DataCrawler
     */
    private $DataCrawler;

    /**
     * Construct a new data builder
     *
     * @param DataCrawler $DataCrawler
     */
    public function __construct(DataCrawler $DataCrawler)
    {
        $this->DataCrawler = $DataCrawler;
    }

    /**
     * Injects data from config into the current view
     *
     * @return array
     */
    public function compile($queue)
    {
        $this->processQueue($queue);

        return $this->data;
    }

    /**
     * Set the data that will be used by a view composer
     *
     * @param array $data
     * @return array
     */
    public function setData($data)
    {
        return $this->data = $data;
    }

    /**
     * Get the data for the view composer
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Gets the value of the view variable from options
     * by parsing the options string and also any parameters
     * for this specific variable.
     *
     * @param $options
     * @throws DeviseRouteConfigurationException
     * @return array
     */
    public function getValue($options)
    {
        try
        {
    	    if (is_string($options))
            {
                // no params defined in the config
                list($classPath, $function) = explode('.', $options);
                $params = array();
            }
            else
            {
                // is it a flat variable which contains the value
    		    if (isset($options['value']))
                {
                    return $options['value'];
                }

                list($classPath, $function) = explode('.', key($options));

                $params = $this->fillParamRequest( reset($options) );

                if (in_array(DataCrawler::PARAM_NOT_FOUND, $params, true))
                {
                    return DataCrawler::PARAM_NOT_FOUND;
                }
            }
        }
        catch (\Exception $e)
        {
            throw new DeviseRouteConfigurationException('Devise route configuration error. Debug: This is likely due to a configuration error in your views.php configuration file or in the pages table. Ensure any functional routes have the following format: This\Is\My\Namespace\ClassName.methodName');
        }

        $classInstance = $this->loadClass($classPath);

        return call_user_func_array(array($classInstance, $function) , $params);
    }

    /**
     * Process queue takes an array and gets the computed value
     * of each value from the array. It populates $this->data
     * which is used later by the view composer when it calls
     * the getData() method.
     *
     * @param  array $queue
     * @return void
     */
    private function processQueue($queue)
    {
        $failures = array();

        foreach ($queue as $varName => $var)
        {
            $value = $this->getValue($var);

            if ($value !== DataCrawler::PARAM_NOT_FOUND)
            {
                $this->data[ $varName ] = $value;
            }
            else
            {
                $failures[ $varName ] = $var;
            }
        }

        if (count($failures))
        {
            // only some items failed trying again with $var instead of $value
            // eventually this should return false so we don't run into an
            // infinite loop b/c eventually count of both variables will be same
            if (count($failures) < count($queue))
            {
                $this->processQueue($failures);
            }
            else
            {
                $this->fillWithNulls($failures);
            }
        }
    }

    /**
     * Fill the failures with null values
     *
     * @param  array $failures
     * @return void
     */
    private function fillWithNulls($failures)
    {
        foreach ($failures as $varName => $var)
        {
            $this->data[ $varName ] = null;
        }
    }

    /**
     * Uses the path from config to load a class
     * if the class is already loaded the instance is returned
     *
     * @return array
     */
    private function loadClass($path)
    {
        if(!isset($this->loadedClasses[ $path ])){

            $this->loadedClasses[ $path ] = \App::make($path);
        }

        return $this->loadedClasses[ $path ];
    }

    /**
     * Loops through params in views config and fills the value of each
     * parameter key => value pair
     *
     * @return array
     */
    private function fillParamRequest($paramRequestList)
    {
        $params = array();
        foreach ($paramRequestList  as $param)
        {
            preg_match_all('/{(.*?)}/', $param, $matches);
            if(isset($matches[1]) && count($matches[1])){
                $params[] = $this->DataCrawler->extract($this->data, $matches[1][0]);
            } else {
                $params[] = $param;
            }
        }

        return $params;
    }
}