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
     * @param $description
     * @param $classAndMethod
     * @param array $params
     * @param array $views
     */
    public static function set($description, $classAndMethod, $params = [], $views = [])
    {
        if (isset(self::$queries[$classAndMethod]))
        {
            abort(500, 'ModelQuery key (' . $classAndMethod . ') already registered. Please use a different name.');
        }

        self::$queries[$classAndMethod] = [
            'key'         => $classAndMethod,
            'description' => $description,
            'params'      => $params,
            'views'       => $views
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

        list($className, $methodName) = explode('@', $query->key);

        $class = App::make($className);

        $params = isset($query->params) ? $query->params : [];

        return call_user_func_array([$class, $methodName], $params);
    }
}