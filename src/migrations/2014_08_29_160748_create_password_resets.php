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
        if (!Schema::hasTable('password_resets'))
        {
            Schema::create('password_resets', function($table) {
                $table->string('email', 255);
                $table->string('token', 255);
                $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            });
        }
        else
        {
            Schema::table('password_resets', function($table)
            {
                if (!Schema::hasColumn('password_resets', 'email')) {
                    $table->string('email', 255);
                }

                if (!Schema::hasColumn('password_resets', 'token')) {
                    $table->string('token', 255);
                }

                if (!Schema::hasColumn('password_resets', 'created_at')) {
                    $table->timestamp('created_at')->default('0000-00-00 00:00:00');
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
        Schema::drop('password_resets');
    }

}