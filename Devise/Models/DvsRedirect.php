<?php

namespace Devise\Models;

class DvsRedirect extends Model
{
  protected $fillable = ['site_id', 'from_url', 'to_url'];

  protected $table = 'dvs_redirects';
}