<?php

namespace Devise\Models;

use Illuminate\Support\Facades\App;

class Repository
{
    public function runQuery($input)
    {
        $classPath = array_get($input, 'class');

        if ($classPath)
        {
            $scopes = array_get($input, 'scopes', []);
            $filters = array_get($input, 'filters');
            $paginated = array_get($input, 'paginated', false);
            $single = array_get($input, 'single', false);
            $sort = array_get($input, 'sort');
            $limit = array_get($input, 'limit', 25);

            try {
                $model = App::make($classPath);
            } catch (\Exception $e) {
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
}