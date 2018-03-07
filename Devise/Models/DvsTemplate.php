<?php

namespace Devise\Models;

use Devise\Devise;

class DvsTemplate extends Model
{
  protected $fillable = ['name', 'layout', 'slices'];

  protected $table = 'dvs_templates';

  protected $attributes = [
    'slices' => '[]'
  ];

  public function pages()
  {
    return $this->hasMany(DvsPageVersion::class, 'template_id');
  }

  public function setSlicesAttribute($value)
  {
    $this->attributes['slices'] = json_encode($value);
  }

  public function getSlicesArrayAttribute()
  {
    return json_decode($this->slices);
  }

  public function registerComponents()
  {
    $slices = DvsSlice::get();
    foreach ($slices as $slice)
    {
      Devise::addComponent($slice);
    }
  }
}