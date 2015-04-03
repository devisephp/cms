<?php

use Illuminate\Database\Migrations\Migration;

class CreateDvsSeeds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dvs_seeds', function($table)
        {
            $table->string('name');
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
        Schema::drop('dvs_seeds');
    }

}