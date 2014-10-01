<?php

use Illuminate\Database\Migrations\Migration;

class CreateDvsCollectionInstance extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dvs_collection_instance', function($table) {
            $table->increments('id');
            $table->integer('collection_set_id')->nullable();
            $table->integer('page_id')->nullable();
            $table->string('name', 50)->nullable();
            $table->integer('sort')->nullable();
            $table->integer('deleted_at')->nullable();
            $table->date('created_at')->nullable();
            $table->date('updated_at')->nullable();

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
        Schema::drop('dvs_collection_instance');
    }

}