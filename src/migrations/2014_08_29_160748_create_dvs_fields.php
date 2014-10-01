<?php

use Illuminate\Database\Migrations\Migration;

class CreateDvsFields extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dvs_fields', function($table) {
            $table->increments('id');
            $table->integer('collection_set_id')->nullable();
            $table->integer('page_id')->unsigned();
            $table->string('type', 25);
            $table->string('human_name', 255)->nullable();
            $table->string('key', 100);
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->dateTime('deleted_at')->nullable();

            $table->index('collection_set_id');
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
        Schema::drop('dvs_fields');
    }

}