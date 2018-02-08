<?php

namespace Devise\Models;

class DvsTemplate extends Model
{
  protected $fillable = ['name', 'layout', 'slots'];

  protected $table = 'dvs_templates';

  protected $attributes = [
    'slots' => '[]'
  ];

  public function pages()
  {
    return $this->hasMany(DvsPageVersion::class, 'template_id');
  }

  public function setSlotsAttribute($value)
  {
    $this->attributes['slots'] = json_encode($value);
  }

  public function getSlotsArrayAttribute()
  {
    return json_decode($this->slots);
  }
}