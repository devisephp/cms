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

    DB::table('dvs_page_versions')->insert([
      array(
        'page_id'            => 1,
        'created_by_user_id' => 1,
        'name'               => 'Default',
        'view'               => 'welcome',
        'starts_at'          => date('Y-m-d H:i:s', strtotime('now -1 hour')),
        'created_at'         => date('Y-m-d H:i:s'),
        'updated_at'         => date('Y-m-d H:i:s'),
      ),
    ]);
  }

}
