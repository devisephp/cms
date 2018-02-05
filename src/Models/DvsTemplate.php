<?php

namespace Devise\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DvsTemplate extends Model
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

    static::addGlobalScope('template', function (Builder $builder) {
      $builder->whereNull('view');
    });
  }

  public function slices()
  {
    return $this->hasMany(DvsSliceInstance::class, 'parent_slice_id');
  }
}