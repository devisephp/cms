<?php

use Illuminate\Database\Migrations\Migration;

class CreateDvsPages extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dvs_pages', function($table) {
            $table->increments('id');
            $table->integer('language_id');
            $table->integer('translated_from_page_id')->default(0);
            $table->string('view', 255)->nullable();
            $table->string('title', 255);
            $table->string('http_verb', 255)->default('get');
            $table->string('route_name', 255);
            $table->boolean('is_admin');
            $table->boolean('dvs_admin');
            $table->string('slug', 255);
            $table->text('short_description')->nullable();
            $table->string('meta_title', 255)->nullable();
            $table->string('meta_description', 255)->nullable();
            $table->string('meta_keywords', 255)->nullable();
            $table->text('head')->nullable();
            $table->text('footer')->nullable();
            $table->text('before')->nullable();
            $table->text('after')->nullable();
            $table->string('response_type', 255)->default('View');
            $table->string('response_path', 255)->nullable();
            $table->string('response_params', 255)->nullable();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->dateTime('deleted_at')->nullable();

            $table->index('language_id');
            $table->index('translated_from_page_id');
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