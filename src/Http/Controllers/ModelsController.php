<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;
use Devise\Models\Repository as ModelRepository;

use Devise\Traits\Filterable;
use Devise\Traits\Sliceable;
use Devise\Traits\Sortable;
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
     * @var ModelRepository
     */
    private $ModelRepository;


    /**
     * SlicesController constructor.
     * @param ModelRepository $ModelRepository
     */
    public function __construct(ModelRepository $ModelRepository)
    {
        $this->ModelRepository = $ModelRepository;
    }

    public function all(ApiRequest $request)
    {
        return $this->findAllModels();
    }

    public function settings(ApiRequest $request)
    {
        $model = App::make($request->get('class'));

        return [
            'name'    => class_basename($model),
            'class'   => get_class($model),
            'columns' => $model->tableColumns ?: []
        ];
    }

    public function query(ApiRequest $request)
    {
        return $this->ModelRepository
            ->runQuery($request->getQueryString());
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
                    $traits = class_uses($class);
                    if (is_subclass_of($class, Model::class) && in_array(Sliceable::class, $traits))
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