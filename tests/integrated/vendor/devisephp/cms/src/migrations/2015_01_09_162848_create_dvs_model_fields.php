<?php

use Illuminate\Database\Migrations\Migration;

class CreateDvsModelFields extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dvs_model_fields', function($table)
        {
            $table->increments('id');
            $table->unsignedInteger('model_id');
            $table->string('model_type');
            $table->string('mapping', 255);
            $table->longText('json_value');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->dateTime('deleted_at')->nullable();

            $table->unique(['model_id', 'model_type', 'mapping'], 'model_id_type_and_mapping_unique_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dvs_model_fields');
    }

}