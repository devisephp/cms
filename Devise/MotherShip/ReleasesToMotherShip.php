<?php

namespace Devise\MotherShip;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use ReflectionClass;
use ReflectionMethod;

trait ReleasesToMotherShip
{
  private $useReleaseArray = false;

  public $saveRelease = true;

  private $mshDependenciesMap = [];

  /**
   *
   */
  protected static function boot()
  {
    parent::boot();

    $log = App::make(DvsRelease::class);

    static::created(function (Model $model) use ($log) {
      if ($model->saveRelease)
      {
        $log->saveCreate($model);
      }
    });

    static::saved(function (Model $model) use ($log) {
      if ($model->saveRelease && $model->created_at != $model->updated_at)
      {
        $log->saveUpdate($model);
      }
    });

    static::deleting(function (Model $model) use ($log) {
      if ($model->saveRelease)
      {
        $log->saveDelete($model);
      }
    });
  }

  /**
   *
   */
  public function prepRelease()
  {
    $this->prepRelations();
    $this->useReleaseArray = true;
  }

  private function prepRelations()
  {
    $publicMethods = $this->getMyPublicMethods();

    foreach ($publicMethods as $method)
    {
      if ($method->getNumberOfParameters() === 0)
      {
        $name = $method->name;
        $result = $this->$name();
        if ($result instanceof Relation)
        {
          DependenciesMap::parseRelation($result);
        }
      }
    }
  }

  private function getMyPublicMethods()
  {
    $methods = [];
    $reflection = new ReflectionClass($this);
    foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method)
    {
      if ($method->class == $reflection->getName() && $method->name != '__call' && $method->name != 'prepRelease')
        $methods[] = $method;
    }

    return $methods;
  }

  public function __call($method, $parameters)
  {
    if ($method != 'toArray' || !$this->useReleaseArray)
    {
      return parent::__call($method, $parameters);
    }

    return $this->getReleaseArray();
  }

  private function getReleaseArray()
  {
    if ($this->useReleaseArray)
    {
      $data = [];
      $columns = Schema::getColumnListing($this->getTable());
      foreach ($columns as $column)
      {
        $value = $this->getAttribute($column);
        if ($value instanceof Carbon)
        {
          $data[$column] = (string)$value;
        } else
        {
          $data[$column] = $value;
        }
      }

      $data['dependencies'] = $this->mshDependenciesMap;

      return $data;
    } else
    {
      parent::toArray();
    }
  }
}