<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDvsMeta extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('dvs_page_meta', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('page_id')->unsigned();
      $table->string('attribute_name');
      $table->string('attribute_value');
      $table->string('content');
      $table->timestamps();

      $table->index('page_id');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('dvs_page_meta');
  }
}
