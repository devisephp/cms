<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropDvsMedia extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('dvs_media');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('dvs_media', function (Blueprint $table) {
            $table->increments('id');
            $table->string('directory');
            $table->string('name');
            $table->integer('size')->unsigned();
            $table->integer('used_count')->unsigned();
            $table->timestamps();
        });
    }
}
