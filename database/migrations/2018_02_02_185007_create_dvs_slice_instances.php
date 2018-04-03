<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDvsSliceInstances extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('dvs_slice_instances', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('page_version_id');
      $table->integer('parent_instance_id');
      $table->integer('template_slice_id');
      $table->boolean('enabled');
      $table->integer('position');
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
    Schema::drop('dvs_slice_instances');
  }
}