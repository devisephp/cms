<?php

namespace Devise\Models;

use Illuminate\Database\Eloquent\Model;

class DvsMigration extends Model
{
  protected $table = 'migrations';

  public function getDateAttribute()
  {
    $parts = explode('_', $this->migration);

    $dateParts = array_slice($parts, 0, 4);

    $dateParts[count($dateParts) - 1] = $this->toTime($dateParts[count($dateParts) - 1]);

    $date = implode('-', $dateParts);


    return substr_replace($date, ' ', 10, 1);
  }

  private function toTime($str)
  {
    return implode(":", str_split($str, 2));
  }
}