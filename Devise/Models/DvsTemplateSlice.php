<?php

namespace Devise\Models;

use Devise\Traits\IsDeviseComponent;

class DvsTemplateSlice extends Model
{
  use IsDeviseComponent;

  protected $fillable = ['template_id', 'parent_id', 'slice_id', 'label', 'position', 'view'];

  protected $table = 'dvs_template_slice';

  protected $attributes = [
    'model_query' => '',
    'config' => ''
  ];

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