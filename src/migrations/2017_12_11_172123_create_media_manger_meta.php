<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaMangerMeta extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('dvs_media_manager', function (Blueprint $table) {
      $table->increments('id');
      $table->string('directory');
      $table->string('name');
      $table->integer('size');
      $table->json('fields');
      $table->json('global_fields');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('dvs_media_manager');
  }
}
