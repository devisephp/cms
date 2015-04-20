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
        if (!Schema::hasTable('group_user'))
        {

            Schema::create('group_user', function($table) {
                $table->integer('group_id');
                $table->integer('user_id');

                $table->primary(array('group_id', 'user_id'));
            });

        } else {

             Schema::table('group_user', function($table) {
                if(!Schema::hasColumn('group_user', 'group_id')) {
                    $table->integer('group_id');
                }

                if(!Schema::hasColumn('group_user', 'user_id')) {
                    $table->integer('user_id')->after('group_id');
                }

                $table->dropPrimary('group_id', 'user_id');
                $table->primary(array('group_id', 'user_id'));
            });

        }
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