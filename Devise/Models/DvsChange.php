<?php

namespace Devise\Models;

use Illuminate\Database\Eloquent\Model;

class DvsChange extends Model
{
  protected $table = 'dvs_changes';

  protected $fillable = ['release_id', 'user_id', 'change'];

  public function user()
  {
    return $this->belongsTo(config('auth.providers.users.model'));
  }

  public function getDescriptionAttribute()
  {
    $description = '';
    if(property_exists($this->change, 'json_value')){
      $description = 'Field value changed.';
    } else {
      foreach ($this->change as $key => $value){
        $description .= $key . ' changed to ' . $value;
      }
    }
    return $description;
  }

  public function getChangeAttribute($value)
  {
    return json_decode($value);
  }

  public function setChangeAttribute($value)
  {
    $this->attributes['change'] = ($value) ? json_encode($value) : '{}';
  }
}