<?php

namespace Devise\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DvsSliceInstance extends Model
{
  protected $guarded = array();

  protected $table = 'dvs_slice_instances';

  public function slice()
  {
    return $this->belongsTo(DvsSlice::class, 'slice_id');
  }

  public function fields()
  {
    return $this->hasMany(DvsField::class, 'slice_instance_id');
  }
}