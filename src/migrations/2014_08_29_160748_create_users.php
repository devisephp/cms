<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('users'))
        {

            // create new
            Schema::create('users', function( $table) {
                $table->increments('id');
                $table->string('name', 255)->nullable();
                $table->string('email', 255)->unique();
                $table->string('password', 255);
                $table->string('remember_token', 255)->nullable();
                $table->boolean('activated')->default(false);
                $table->boolean('activate_code')->nullable();
                $table->softDeletes();
            });

        } else {

            // check and create any required Devise columns
            Schema::table('users', function($table) {
                if(!Schema::hasColumn('users', 'name')) {
                    $table->string('name', 255)->nullable();
                }

                if(!Schema::hasColumn('users', 'email')) {
                    $table->string('email', 255)->unique();
                }

                if(!Schema::hasColumn('users', 'password')) {
                    $table->string('password', 255);
                }

                if(!Schema::hasColumn('users', 'remember_token')) {
                    $table->rememberToken();
                }

                if(!Schema::hasColumn('users', 'activated')) {
                    $table->boolean('activated')->default(false);
                }

                if(!Schema::hasColumn('users', 'activate_code')) {
                    $table->boolean('activate_code')->nullable();
                }

                if(!Schema::hasColumn('users', 'deleted_at')) {
                    $table->softDeletes();
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
        Schema::drop('users');
    }

}