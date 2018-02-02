<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviseSitesSeeder extends Seeder
{

  public function run()
  {
    DB::table('dvs_sites')->insert([
      array(
        'domains'     => 'devise.test',
        'created_at'  => date('Y-m-d H:i:s'),
        'updated_at'  => date('Y-m-d H:i:s'),
      ),
    ]);
  }

}
