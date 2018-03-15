<?php

namespace Devise\Models;

use Devise\Devise;

class DvsTemplate extends Model
{
  protected $fillable = ['name', 'layout'];

  protected $table = 'dvs_templates';

  protected $attributes = [];

  public function pages()
  {
    return $this->hasMany(DvsPageVersion::class, 'template_id');
  }

  public function slices()
  {
    return $this->hasMany(DvsTemplateSlice::class, 'template_id')
      ->orderBy('position')
      ->where('parent_id', 0);
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