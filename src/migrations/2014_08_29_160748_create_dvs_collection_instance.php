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
        Schema::create('dvs_collection_instance', function($table)
        {
            $table->increments('id');
            $table->integer('collection_set_id');
            $table->unsignedInteger('page_version_id');
            $table->string('name', 50);
            $table->integer('sort');
            $table->integer('deleted_at')->nullable();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->index('collection_set_id');
            $table->index('page_version_id');
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