<?php

namespace Devise\MotherShip;

use Illuminate\Database\Eloquent\Relations\Relation;

class DependenciesMap
{
  private static $map = [];

  public static function newRelease()
  {
    self::$map = [];
  }

  public static function parseRelation(Relation $relation)
  {
    $className = class_basename($relation);

    self::addToMap(
      $relation->getParent()->getTable(),
      $relation->getTable(),
      $relation->getForeignPivotKeyName()
    );

    switch ($className)
    {
      case 'BelongsToMany';
      case 'hasManyThrough';
      case 'MorphToMany';

        self::addToMap(
          $relation->getRelated()->getTable(),
          $relation->getTable(),
          $relation->getRelatedPivotKeyName()
        );

        break;
    }
  }

  public static function getMap()
  {
    return self::$map;
  }

  private static function addToMap($originTable, $relatedTable, $fieldName)
  {
    if (!isset(self::$map[$originTable]))
    {
      self::$map[$originTable] = [];
    }

    self::$map[$originTable][$relatedTable] = $fieldName;
  }
}