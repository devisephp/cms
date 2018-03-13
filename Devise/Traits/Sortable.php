<?php

namespace Devise\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait Sortable
 * @package App\Traits
 */
trait Sortable
{
  /**
   * @param Builder $q
   * @param $input
   * @param null $threshold
   * @param bool $entireText
   * @param bool $entireTextOnly
   * @return Builder
   */
  public function scopeSort(Builder $q, $input, $threshold = null, $entireText = false, $entireTextOnly = false)
  {
    if ($input)
    {
      $paramsArr = explode(',', $input);
      foreach ($paramsArr as $param)
      {
        $q = $this->applySort($q, $param);
      }
    }

    return $q;
  }

  /**
   * @param Builder $q
   * @param string $field query value of sort. asc: name of a db field. desc: name of db field with "-" prefix
   * @return Builder
   */
  private function applySort($q, $field)
  {
    $dir = 'asc';

    if (strpos($field, '-') === 0)
    {
      $dir = 'desc';
      $field = substr($field, 1);
    }

    if(strpos($field,'.') !== false){
      $qg = $this->joinRelation($q, $field);
    }

    $method = 'sortBy' . ucfirst($field);
    if (method_exists($this, $method))
    {
      return $this->$method($q, $dir);
    }

    return $q->orderBy($field, $dir);
  }

  private function joinRelation($q, &$field)
  {
    list($relation, $field) = explode('.', $field);

    $relationTable = $this->$relation()->getRelated()->getTable();
    $owner = $this->$relation()->getQualifiedOwnerKeyName();
    $foreign = $this->$relation()->getQualifiedForeignKey();

    $field = $relationTable . '.' . $field;

    return $q->join($relationTable, $owner, '=', $foreign);
  }

}