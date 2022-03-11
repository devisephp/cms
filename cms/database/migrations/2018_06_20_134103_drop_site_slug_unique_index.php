<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropSiteSlugUniqueIndex extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('dvs_pages', function (Blueprint $table) {
      $table->dropUnique('slug_site_unique');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('dvs_pages', function (Blueprint $table) {
      $table->unique(['slug', 'site_id'], 'slug_site_unique');
    });
  }
}
