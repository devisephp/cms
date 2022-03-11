<?php

namespace Devise\Models;

use Devise\Languages\LanguageDetector;
use Devise\Sites\SiteDetector;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;

class Repository
{
    private static $queries = [];

    private $SiteDetector;

    private $LanguageDetector;

    /**
     *
     */
    public function __construct(SiteDetector $SiteDetector, LanguageDetector $LanguageDetector)
    {
        $this->SiteDetector = $SiteDetector;
        $this->LanguageDetector = $LanguageDetector;
    }

    public function runQuery($paramsString)
    {
        parse_str($paramsString, $params);

        if (!array_key_exists($paramsString, self::$queries))
        {
            if ($this->shouldCacheData($params))
            {
                $key = $this->getCacheKey($paramsString);
                self::$queries[$paramsString] = Cache::rememberForever($key, function () use ($params) {
                    return $this->getRecords($params);
                });
            } else
            {
                self::$queries[$paramsString] = $this->getRecords($params);
            }
        }

        return self::$queries[$paramsString];
    }

    private function getCacheKey($seed)
    {
        $site = $this->SiteDetector->current();
        $lang = $this->LanguageDetector->current();

        return $site->id . '.' . $lang->id . '.' . md5($seed);
    }

    private function getRecords($params)
    {
        $classPath = Arr::get($params, 'class');

        if ($classPath)
        {
            $scopes = Arr::get($params, 'scopes', []);
            $filters = Arr::get($params, 'filters');
            $paginated = Arr::get($params, 'paginated', false);
            $single = Arr::get($params, 'single', false);
            $sort = Arr::get($params, 'sort');
            $limit = Arr::get($params, 'limit', 25);

            try
            {
                $model = App::make($classPath);
            } catch (\Exception $e)
            {
                return [];
            }

            foreach ($scopes as $scopeNames)
            {
                foreach ($scopeNames as $function => $params)
                {
                    if ($params)
                    {
                        $model = $model->$function($params);
                    } else
                    {
                        $model = $model->$function();
                    }
                }
            }

            $model = $model->filter($filters)
                ->sort($sort);

            if (!$single)
            {
                if ($paginated)
                {
                    return $model->paginate($limit);
                } else
                {
                    return $model->get();
                }
            } else
            {
                return $model->first();
            }
        }

        abort(401, 'Class parameter not found in query.');
    }

    private function shouldCacheData($params)
    {
        if (isset($params['cache']))
        {
            $cache = filter_var($params['cache'], FILTER_VALIDATE_BOOLEAN);
            if ($cache && config('devise.cache_enabled'))
            {
                return true;
            }
        }

        return false;
    }
}