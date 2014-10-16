<?php

use Illuminate\Database\Migrations\Migration;

class CreateDvsGlobalFields extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dvs_page_schedules', function($table)
        {
            $table->increments('id');
            $table->unsignedInteger('page_id');
            $table->unsignedInteger('page_version_id');
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dvs_global_fields');
    }

}