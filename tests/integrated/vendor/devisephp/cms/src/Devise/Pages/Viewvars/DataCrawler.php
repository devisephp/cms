<?php namespace Devise\Pages\Viewvars;

/**
 * Purpose of this class is to turn something like this
 * in the view vars into a parameter value we can use.
 *
 * 'someVar' => ['Some\Namespaced\Class.methodName' => ['value' => 'asfd', 'params.pageId', 'input']]
 *
 */
class DataCrawler
{
    /**
     * This is used to denote that a parameter was not found
     */
    const PARAM_NOT_FOUND = '@@*XX--PARAM NOT FOUND--XX*@@';

    /**
     * Gets the value of a param by it's name
     *
     * @param  array $data
     * @param  string $dotPath
     * @return mixed
     */
    public function extract($data, $dotPath)
    {
        $path = explode('.', trim($dotPath));

        $value = $this->followDataPath($data, $path);

        return $value !== self::PARAM_NOT_FOUND ? $value : null;
    }

    /**
     * Follows an array recursively to retrieve data from view objects
     *
     * @param  array  $data
     * @param  string  $path
     * @param  integer $index
     * @return mixed
     */
    private function followDataPath($data, $path, $index = 0)
    {
        $value = $this->getUsingString($data, $path[ $index ]);

        if ($value !== self::PARAM_NOT_FOUND)
        {
            return $index < count($path) - 1 ? $this->followDataPath($value, $path, $index + 1) : $value;
        }

        return self::PARAM_NOT_FOUND;
    }

    /**
     * Gets a property from an object or an array using a string
     *
     * @param  object  $data
     * @param  string $propertyName
     * @return mixed
     */
    private function getUsingString($data, $propertyName)
    {
        if (is_array($data) && isset($data[$propertyName]))
        {
            return $data[ $propertyName ];
        }

        if (is_object($data) && $this->propertyAvailable($data, $propertyName) !== self::PARAM_NOT_FOUND)
        {
            return $data->$propertyName;
        }

        return self::PARAM_NOT_FOUND;
    }

    /**
     * Tells us if this property is available on this object
     *
     * @param  object $object
     * @param  string $name
     * @return mixed
     */
    private function propertyAvailable($object, $name)
    {
        try
        {
            return $object->$name;
        }
        catch (\Exception $e) { }

        return self::PARAM_NOT_FOUND;
    }
}