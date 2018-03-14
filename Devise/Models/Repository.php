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
      $filters = array_get($input, 'filters');
      $paginated = array_get($input, 'paginated', false);
      $sort = array_get($input, 'sort');
      $limit = array_get($input, 'limit', 25);

      $model = App::make($classPath);

      $model = $model->filter($filters)
        ->sort($sort);

      if ($paginated)
      {
        return $model->paginate($limit);
      } else
      {
        return $model->get();
      }
    }

    abort(401, 'Class parameter not found in query.');
  }
}