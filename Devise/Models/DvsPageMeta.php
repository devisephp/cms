<?php

namespace Devise\Models;

class DvsPageMeta extends Model
{
  public $fillable = ['attribute_name','attribute_value','content'];

  protected $table = 'dvs_page_meta';

  protected $attributes = [
    'page_id' => 0
  ];
}