<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDvsFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('dvs_fields', function($table)
      {
        $table->increments('id');
        $table->unsignedInteger('slice_instance_id')->nullable();
        $table->string('type', 25);
        $table->string('human_name', 255)->nullable();
        $table->string('key', 100);
        $table->longText('json_value');
        $table->boolean('content_requested')->default(false);
        $table->timestamps();

        $table->index('slice_instance_id');
        $table->unique(['slice_instance_id', 'key'], 'slice_key_unique_index');
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
