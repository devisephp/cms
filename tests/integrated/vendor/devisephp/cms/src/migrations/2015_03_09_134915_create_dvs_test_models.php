<?php

use Illuminate\Database\Migrations\Migration;

class CreateDvsTestModels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dvs_test_models', function($table)
        {
            $table->increments('id');
            $table->unsignedInteger('page_version_id');
            $table->string('name', 50);
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
        Schema::drop('dvs_test_models');
    }

}