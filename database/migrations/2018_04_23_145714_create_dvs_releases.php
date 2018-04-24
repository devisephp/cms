<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDvsReleases extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('dvs_releases', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('model_id')->unsigned();
      $table->string('model_name');
      $table->integer('msh_id')->unsigned();
      $table->timestamps();
      $table->softDeletes();
      $table->unique(['model_id', 'model_name'], 'model_id_name');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('dvs_releases');
  }
}
