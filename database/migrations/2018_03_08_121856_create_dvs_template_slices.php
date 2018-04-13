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
      $table->string('view');
      $table->string('type');
      $table->string('label');
      $table->integer('position')->unsigned();
      $table->text('model_query');
      $table->text('config');
      $table->timestamps();

      $table->index('template_id');
      $table->index('parent_id');
      $table->index('slice_id');
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
