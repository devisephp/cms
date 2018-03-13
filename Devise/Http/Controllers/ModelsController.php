<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;
use Devise\Models\DvsSlice;

use Illuminate\Console\DetectsApplicationNamespace;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\App;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;

class ModelsController extends Controller
{
  use DetectsApplicationNamespace;

  /**
   * @var DvsSlice
   */
  private $DvsSlice;


  /**
   * SlicesController constructor.
   * @param DvsSlice $DvsSlice
   */
  public function __construct(DvsSlice $DvsSlice)
  {
    $this->DvsSlice = $DvsSlice;
  }

  public function all(ApiRequest $request)
  {
    return $this->findAllModels();
  }

  public function query(ApiRequest $request)
  {
    $model = App::make($request->get('class'));

    $model = $model->filter($request->get('filters'))
      ->sort($request->get('sort', null));

    if ($request->get('paginated', false))
    {
      return $model->paginate($request->get('limit', 25));
    } else
    {
      return $model->get();
    }
  }

  private function findAllModels()
  {
    $path = app_path();
    $models = array();

    $allFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
    $phpFiles = new RegexIterator($allFiles, '/\.php$/');
    foreach ($phpFiles as $phpFile)
    {
      $content = file_get_contents($phpFile->getRealPath());
      $tokens = token_get_all($content);
      $namespace = '';
      for ($index = 0; isset($tokens[$index]); $index++)
      {
        if (!isset($tokens[$index][0]))
        {
          continue;
        }
        if (T_NAMESPACE === $tokens[$index][0])
        {
          $index += 2; // Skip namespace keyword and whitespace
          while (isset($tokens[$index]) && is_array($tokens[$index]))
          {
            $namespace .= $tokens[$index++][1];
          }
        }
        if (T_CLASS === $tokens[$index][0])
        {
          $index += 2; // Skip class keyword and whitespace
          $class = $namespace . '\\' . $tokens[$index][1];
          if (is_subclass_of($class, Model::class))
          {
            $model = App::make($class);

            $models[] = [
              'name'    => $tokens[$index][1],
              'class'   => $class,
              'columns' => $model->tableColumns ?: []
            ];
          }
          break;
        }
      }
    }

    return $models;
  }
}