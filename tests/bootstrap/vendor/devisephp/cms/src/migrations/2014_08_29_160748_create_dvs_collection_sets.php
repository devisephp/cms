<?php

use Illuminate\Database\Migrations\Migration;

class CreateDvsCollectionSets extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dvs_collection_sets', function($table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dvs_collection_sets');
    }

}