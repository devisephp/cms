<?php

namespace Devise\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class DvsSliceInstance extends Model
{
  protected $fillable = ['page_version_id','parent_instance_id','template_slice_id','enabled'];

  protected $table = 'dvs_slice_instances';

  public $parent_type = 'single';

  public function templateSlice()
  {
    return $this->belongsTo(DvsTemplateSlice::class, 'template_slice_id');
  }

  public function slices()
  {
    return $this->hasMany(DvsSliceInstance::class, 'parent_instance_id')
      ->orderBy('position');
  }

  public function fields()
  {
    return $this->hasMany(DvsField::class, 'slice_instance_id');
  }
}