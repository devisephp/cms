<?php

use Illuminate\Database\Migrations\Migration;

class CreatePasswordResets extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('password_resets', function($table) {
            $table->string('email', 255);
            $table->string('token', 255);
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('password_resets');
    }

}