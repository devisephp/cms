<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviseInstall extends Seeder
{

  public function run()
  {
    DB::table('dvs_languages')->truncate();
    DB::table('dvs_page_versions')->truncate();
    DB::table('dvs_pages')->truncate();
    DB::table('dvs_sites')->truncate();

    $this->call([
      LanguagesSeeder::class,
      PagesSeeder::class,
      SitesSeeder::class
    ]);
  }

}
