<?php

namespace Devise\Models;

class DvsRedirect extends Model
{
  public $fillable = ['site_id', 'from_url', 'to_url'];

  protected $table = 'dvs_redirects';

  protected $attributes = [
      'type' => 301
  ];
}