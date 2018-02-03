<?php

namespace Devise\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DvsSlice extends Model
{
  protected $guarded = array();

  protected $table = 'dvs_slices';

  /**
   * The "booting" method of the model.
   *
   * @return void
   */
  protected static function boot()
  {
    parent::boot();

    static::addGlobalScope('slice', function (Builder $builder) {
      $builder->whereNotNull('view');
    });
  }

  public function slices()
  {
    return $this->belongsToMany(DvsSlice::class, 'dvs_slice_instances', 'parent_slice_id', 'slice_id');
  }
}