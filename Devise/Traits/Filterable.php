<?php

namespace Devise\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Trait Filterable
 *
 * JS ObjectExample:
 * {
 *   "filters": {
 *     "related" : {
 *         "categories.id": "1,2,3,4"
 *      },
 *     "search" : {
 *         "title": "search term"
 *      },
 *     "match" : {
 *         "title": "search term"
 *      },
 *     "dates" : {
 *         "created_at": "after,before"
 *      },
 *     "ranges" : {
 *         "budget": "greater than,less than"
 *      }
 *   }
 * }
 *
 * URL Query Example:
 * ?filters[related][categories.id]=1,2,3,4&filters[search][title]=term&filters[dates][created_at]=after,before
 *
 * @package App\Traits
 */
trait Filterable
{
  /**
   * @param Builder $q
   * @param $input
   * @param null $threshold
   * @param bool $entireText
   * @param bool $entireTextOnly
   * @return Builder
   */
  public function scopeFilter(Builder $q, $input, $threshold = null, $entireText = false, $entireTextOnly = false)
  {
    if ($input)
    {
      foreach ($input as $type => $filters)
      {
        if (is_array($filters))
        {
          foreach ($filters as $field => $value)
          {
            $filter = $this->extrapolate($type, $field, $value);
            $q = $this->applyFilters($q, $filter);
          }
        }
      }
    }

    return $q;
  }

  private function applyFilters(Builder $q, $filter)
  {
    extract($filter);

    if (method_exists($this, $overwriteMethodName))
      return $this->$overwriteMethodName($q, $filter);

    return $this->$baseMethodName($q, $filter);
  }

  /**
   * @param $q
   * @param $filter
   * @return mixed
   */
  private function filterRelated(Builder $q, $filter)
  {
    extract($filter);

    $relationTable = $this->$relation()->getRelated()->getTable();

    return $q->whereHas($relation, function (Builder $q) use ($relationTable, $field, $value) {
      $q->whereIn($relationTable . '.' . $field, $value);
    });
  }

  /**
   * @param $query
   * @param $filter
   * @return mixed
   */
  private function filterSearch($query, $filter)
  {
    extract($filter);

    return $query->where($field, 'LIKE', '%' . $value . '%');
  }

  /**
   * @param $query
   * @param $filter
   * @return mixed
   */
  private function filterMatch($query, $filter)
  {
    extract($filter);

    return $query->where($field, $value);
  }

  /**
   * @param $query
   * @param $filter
   * @return mixed
   */
  private function filterDates($query, $filter)
  {
    extract($filter);

    list($after, $before) = $value;

    if ($after !== "") $query = $query->where($field, '>', date('Y-m-d H:i:s', strtotime($after)));
    if ($before !== "") $query = $query->where($field, '<', date('Y-m-d H:i:s', strtotime($before)));

    return $query;
  }

  /**
   * @param $query
   * @param $filter
   * @return mixed
   */
  private function filterRanges($query, $filter)
  {
    extract($filter);

    list($greatherThan, $lessThan) = $value;

    if ($greatherThan !== "") $query = $query->where($field, '>', $greatherThan);
    if ($lessThan !== "") $query = $query->where($field, '<', $lessThan);

    return $query;
  }

  /**
   * @param $type
   * @param $filter
   */
  private function extrapolate($type, $field, $value)
  {
    $method = 'configure' . ucfirst($type);
    $new = $this->$method($field, $value);

    $new['baseMethodName'] = 'filter' . ucfirst($type);
    $new['overwriteMethodName'] = $new['baseMethodName'] . ucfirst($new['relation']) . ucfirst($new['field']);

    return $new;
  }

  /**
   * @param $field
   * @param $value
   * @return array
   */
  private function configureRelated($field, $value)
  {
    list($relationName, $fieldName) = explode('.', $field);

    return [
      'relation' => $relationName,
      'field'    => $fieldName,
      'value'    => explode(',', $value),
    ];
  }

  /**
   * @param $field
   * @param $value
   * @return array
   */
  private function configureSearch($field, $value)
  {
    return [
      'relation' => '',
      'field'    => $field,
      'value'    => $value,
    ];
  }

  /**
   * @param $field
   * @param $value
   * @return array
   */
  private function configureMatch($field, $value)
  {
    return [
      'relation' => '',
      'field'    => $field,
      'value'    => $value,
    ];
  }

  /**
   * @param $field
   * @param $value
   * @return array
   */
  private function configureDates($field, $value)
  {
    return [
      'relation' => '',
      'field'    => $field,
      'value'    => explode(',', $value),
    ];
  }

  /**
   * @param $field
   * @param $value
   * @return array
   */
  private function configureRanges($field, $value)
  {
    return [
      'relation' => '',
      'field'    => $field,
      'value'    => explode(',', $value),
    ];
  }

  /**
   * @param $array
   * @return mixed
   */
  private function getFirstKey($array)
  {
    $keys = array_keys($array);

    return reset($keys);
  }

}