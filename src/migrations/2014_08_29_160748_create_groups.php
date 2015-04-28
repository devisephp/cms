<?php

use Illuminate\Database\Migrations\Migration;

class CreateGroups extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('groups'))
        {
            Schema::create('groups', function($table) {
                $table->increments('id');
                $table->string('name', 255);
                $table->timestamp('created_at')->default('0000-00-00 00:00:00');
                $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            });
        }
        else
        {
            Schema::table('groups', function($table)
            {
                if (!Schema::hasColumn('groups', 'id')) {
                    $table->increments('id');
                }

                if (!Schema::hasColumn('groups', 'name')) {
                    $table->string('name', 255);
                }

                if (!Schema::hasColumn('groups', 'created_at')) {
                    $table->timestamp('created_at')->default('0000-00-00 00:00:00');
                }

                if (!Schema::hasColumn('groups', 'updated_at')) {
                    $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
                }
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
        Schema::drop('groups');
    }

}