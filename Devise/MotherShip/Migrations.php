<?php


namespace Devise\MotherShip;

use Illuminate\Database\Migrations\Migrator;

class Migrations extends Migrator
{
  public function getQueriesBetweenDates($start, $end)
  {
    dd($start, $end);
    $all = [];

    return $all;
  }
}