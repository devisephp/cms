<?php

use Illuminate\Database\Migrations\Migration;

class CreateGroupUser extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_user', function($table) {
            $table->integer('group_id');
            $table->integer('user_id');

            $table->primary(array('group_id', 'user_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('group_user');
    }

}