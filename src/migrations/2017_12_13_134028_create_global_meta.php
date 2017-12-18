<?php

use Illuminate\Database\Migrations\Migration;

class CreateGlobalMeta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dvs_meta', function($table)
        {
            $table->increments('id');
            $table->string('key');
            $table->integer('page_id')->nullable();
            $table->string('property');
            $table->string('value');
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
        Schema::drop('dvs_meta');
    }

}
