<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDvsTemplateSlices extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('dvs_template_slice', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('template_id')->unsigned();
      $table->integer('parent_id')->unsigned();
      $table->integer('slice_id')->unsigned();
      $table->string('type');
      $table->string('label');
      $table->integer('position')->unsigned();
      $table->string('model');
      $table->text('model_query');
      $table->text('config');
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
    Schema::drop('dvs_template_slice');
  }
}
