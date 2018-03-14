<?php

namespace Devise\Models;

class DvsTemplateSlice extends Model
{
  protected $fillable = ['template_id', 'parent_id', 'slice_id', 'label', 'position'];

  protected $table = 'dvs_template_slice';

  protected $attributes = [
    'model_query' => '',
    'config' => ''
  ];

  /**
   *
   */
  public function slice()
  {
    return $this->belongsTo(DvsSlice::class, 'slice_id');
  }

  /**
   *
   */
  public function slices()
  {
    return $this->hasMany(DvsTemplateSlice::class, 'parent_id')
      ->orderBy('position');
  }

  public function setConfigAttribute($value)
  {
    $this->attributes['config'] = ($value) ? json_encode($value) : "";
  }

  public function getConfigAttribute($value)
  {
    return json_decode($value);
  }
}