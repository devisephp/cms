<?php

namespace Devise;

use Devise\Http\Resources\Vue\PageResource;
use Devise\Http\Resources\Vue\SiteResource;
use Devise\Http\Resources\Vue\TemplateResource;
use Devise\Models\DvsPageMeta;
use Devise\Sites\SiteDetector;
use Devise\Support\Database;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\Session;
use KgBot\LaravelLocalization\Facades\ExportLocalizations as LaravelLocalization;

/**
 * @todo refactor to a facade pattern
 */
class ModelQueries
{
    private static $queries = [];

    public static function all()
    {
        return self::$queries;
    }

    public static function set($name, $description, $class, $method, $params = [])
    {
        if (isset(self::$queries[$name]))
        {
            abort('ModelQuery name already exists. Please use a different name.', 500);
        }

        self::$queries[$name] = [
            'key'         => $name,
            'description' => $description,
            'class'       => $class,
            'method'      => $method,
            'params'      => $params
        ];
    }

    public static function runQuery($query)
    {
        if (!isset(self::$queries[$query->key]))
        {
            abort('ModelQuery ' . $query->key . ' does not exists.', 500);
        }

        $data = self::$queries[$query->key];

        $class = App::make($data['class']);
        $params = isset($query->params) ? $query->params : [];

        return call_user_func_array([$class, $data['method']], $params);
    }
}