<?php

use Devise\Pages\Fields\LiveFieldValue;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class DvsMediaManager extends Model
{
  public $table = 'dvs_media_manager';

  public function getMediaPathAttribute($value)
  {
    if($this->directory == ""){
      return '/media/' . $this->name;
    }

    return '/media/' . $this->directory . '/' . $this->name;
  }
}