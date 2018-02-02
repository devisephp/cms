<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DevisePagesSeeder extends Seeder
{

  public function run()
  {
    DB::table('dvs_pages')->insert([
      array(
        'site_id'     => '1',
        'language_id' => '45',
        'title'       => 'Welcome',
        'route_name'  => 'welcome-to-devise',
        'slug'        => '/',
        'created_at'  => date('Y-m-d H:i:s'),
        'updated_at'  => date('Y-m-d H:i:s'),
      ),
    ]);
  }

}
