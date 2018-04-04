<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDvsSiteElements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('dvs_site_element', function (Blueprint $table) {
        $table->increments('id');
        $table->integer('site_id')->unsigned();
        $table->morphs('element');
        $table->boolean('default');
        $table->timestamps();

        $table->index('site_id');
      });
    }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('dvs_site_element');
  }
}
