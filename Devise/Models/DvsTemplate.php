<?php

namespace Devise\Models;

use Devise\Devise;

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

  public function registerComponents()
  {
    $this->findComponents($this->slots_array);
  }

  private function findComponents($slots)
  {
    foreach ($slots as $slot)
    {
      if ($slot->id)
      {
        $slice = DvsSlice::find($slot->id);
        Devise::addComponent($slice);
      }

      if(isset($slot->slices))
      {
        $this->findComponents($slot->slices);
      }
    }
  }
}