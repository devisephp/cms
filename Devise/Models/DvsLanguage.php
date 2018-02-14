<?php

namespace Devise\Models;

class DvsLanguage extends Model
{
  protected $table = 'dvs_languages';

  public $fillable = ['code', 'human_name', 'regional_human_name'];

  public function pages()
  {
    return $this->hasMany('DvsPage', 'language_id');
  }

  public function getNameAttribute()
  {
    return $this->regional_human_name ?: $this->human_name;
  }
}