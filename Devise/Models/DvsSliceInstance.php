<?php

namespace Devise\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class DvsSliceInstance extends Model
{
  protected $fillable = ['page_version_id','parent_instance_id','slice_id','label'];

  protected $table = 'dvs_slice_instances';

  public function slice()
  {
    return $this->belongsTo(DvsSlice::class, 'slice_id');
  }

  public function slices()
  {
    return $this->hasMany(DvsSliceInstance::class, 'parent_instance_id');
  }

  public function fields()
  {
    return $this->hasMany(DvsField::class, 'slice_instance_id');
  }
}