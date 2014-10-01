<?php namespace Devise\Pages\Data;

class DataCrawler {
    const PARAM_NOT_FOUND = '@@*XX--PARAM NOT FOUND--XX*@@';

    /**
    * Gets the value of a param by it's name
    *
    * @return array
    **/
    public function extract($data, $dotPath)
    {
        $path = explode('.', trim($dotPath));
        $value = $this->followDataPath($data, $path);
        if($value !== self::PARAM_NOT_FOUND){
            return $value;
        }

        return null;
    }

    /**
    * Follows an array recursively to retrieve data from view objects
    *
    **/
    private function followDataPath($data, $path, $index = 0)
    {
        $value = $this->getUsingString($data, $path[ $index ]);
        if($value !== self::PARAM_NOT_FOUND){
            if($index < (count($path) - 1)){
                return $this->followDataPath($value, $path, $index + 1);
            } else {
                return $value;
            }
        }

        return self::PARAM_NOT_FOUND;
    }

    /**
    * gets a property from an object or an array using a string
    *
    **/
    private function getUsingString($data, $propertyName)
    {
        if(is_array($data) && isset($data[ $propertyName ])){
            return $data[ $propertyName ];
        }
        if(is_object($data) && $this->popertyAvailable($data, $propertyName) !== self::PARAM_NOT_FOUND){
            return $data->$propertyName;
        }

        return self::PARAM_NOT_FOUND;
    }

    private function popertyAvailable($object, $name)
    {
        try{
            return $object->$name;
        } catch (\Exception $e){
            return self::PARAM_NOT_FOUND;
        }
    }
}