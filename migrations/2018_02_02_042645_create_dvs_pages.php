<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDvsPages extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('dvs_pages', function (Blueprint $table) {
      $table->increments('id');
      $table->integer('site_id')->unsigned()->default(1);
      $table->integer('language_id');
      $table->integer('translated_from_page_id')->default(0);
      $table->string('title', 255);
      $table->string('http_verb', 255)->default('get');
      $table->string('route_name', 255);
      $table->string('slug', 255);
      $table->string('canonical')->nullable();
      $table->text('head')->nullable();
      $table->text('footer')->nullable();
      $table->text('middleware')->nullable()->default('web');
      $table->boolean('ab_testing_enabled')->default(false);
      $table->timestamps();
      $table->softDeletes();

      $table->index('language_id');
      $table->index('translated_from_page_id');
      $table->unique(['slug', 'http_verb']);
      $table->unique('route_name');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::drop('dvs_pages');
  }
}
