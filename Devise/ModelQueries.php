<?php

namespace Devise;

use Illuminate\Support\Facades\App;

class ModelQueries
{
    private static $queries = [];

    /**
     * @return array
     */
    public static function all()
    {
        return self::$queries;
    }

    /**
     * @param $key
     * @param $description
     * @param $class
     * @param $method
     * @param array $params
     */
    public static function set($key, $description, $class, $method, $params = [])
    {
        if (isset(self::$queries[$key]))
        {
            abort(500, 'ModelQuery key (' . $key . ') already registered. Please use a different name.');
        }

        self::$queries[$key] = [
            'key'         => $key,
            'description' => $description,
            'class'       => $class,
            'method'      => $method,
            'params'      => $params
        ];
    }

    /**
     * @param $query
     * @return mixed
     */
    public static function runQuery($query)
    {
        if (!isset(self::$queries[$query->key]))
        {
            abort(500, 'ModelQuery "' . $query->key . '" has not been registered.');
        }

        $data = self::$queries[$query->key];

        $class = App::make($data['class']);
        $params = isset($query->params) ? $query->params : [];

        return call_user_func_array([$class, $data['method']], $params);
    }
}