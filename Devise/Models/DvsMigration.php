<?php

namespace Devise\Models;

use Illuminate\Database\Eloquent\Model;

class DvsMigration extends Model
{
  protected $table = 'migrations';

  public function getDateAttribute()
  {
    $parts = explode('_', $this->migration);
    $dateParts = array_slice(0, 3);

    dd($dateParts);
  }
}