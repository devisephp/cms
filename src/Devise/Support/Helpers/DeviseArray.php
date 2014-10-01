<?php namespace Devise\Support\Helpers;

use RecursiveIteratorIterator;
use RecursiveArrayIterator;
class DeviseArray {

    public function isOneDimensional($array)
    {
        return (count($array) == count($array, COUNT_RECURSIVE));
    }

    public function isAssoc($arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    public function numericKeys($array)
    {
        return array_filter(array_keys($array), 'is_int');
    }

    public function assocKeys($array)
    {
        foreach($array as $k => $v)
        {
            if(is_int($k))
            {
                unset($array[$k]);
            }
        }
        return $array;
    }

    /**
     * flattens an array into a one dimensional array of namespaces
     *
     * @return array
     */
    public function flattenArray($arr, $exceptions = array(), $pathDelimeter = '.', $valueDelimeter = '.', $skipNumericKeys = true)
    {
        $iterator = new RecursiveArrayIterator($arr);
        $ritit = new RecursiveIteratorIterator($iterator);

        $result = array();
        foreach ($ritit as $leafValue) {
            $keys = array();
            $maxDepth = 99999;
            foreach (range(0, $ritit->getDepth()) as $depth) {
                $key = $ritit->getSubIterator($depth)->key();

                if(in_array($key, $exceptions)){
                    $maxDepth = $depth;
                } else if($depth < $maxDepth){
                    $maxDepth = 99999;
                }

                if($depth >= $maxDepth || ($skipNumericKeys && is_numeric($key))) continue;

                $keys[] = $key;
            }

            if($depth < $maxDepth){
                $result[] = join($pathDelimeter, $keys) . $valueDelimeter . $leafValue;
            } else {
                $result[] = join($pathDelimeter, $keys);
            }
        }

        return array_unique($result);
    }
} 