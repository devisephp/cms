<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDvsRedirects extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('dvs_redirects', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('site_id')->unsigned();
      $table->integer('type')->default(301)->unsigned();
      $table->string('from_url');
      $table->string('to_url');
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
    Schema::drop('dvs_redirects');
  }
}
