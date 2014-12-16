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
        Schema::create('dvs_global_fields', function($table)
        {
            $table->increments('id');
            $table->unsignedInteger('language_id');
            $table->string('type', 25);
            $table->string('human_name', 255)->nullable();
            $table->string('key', 100);
            $table->longText('json_value');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->dateTime('deleted_at')->nullable();

            $table->index('language_id');
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