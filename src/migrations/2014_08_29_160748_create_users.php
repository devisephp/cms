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
                $table->string('username', 255)->unique()->nullable();
                $table->string('password', 255);
                $table->string('remember_token', 255)->nullable();
                $table->boolean('activated')->default(false);
                $table->string('activate_code',255)->nullable();
                $table->timestamps();
                $table->softDeletes();
            });

        } else {

            // check and create any required Devise columns
            Schema::table('users', function($table) {
                if(!Schema::hasColumn('users', 'name')) {
                    $table->string('name', 255)->after('id')->nullable();
                } else {
                    $table->string('name', 255)->nullable()->change();
                }

                if(!Schema::hasColumn('users', 'email')) {
                    $table->string('email', 255)->after('name')->unique();
                }

                if(!Schema::hasColumn('users', 'username')) {
                    $table->string('username', 255)->after('email')->unique()->nullable();
                }

                if(!Schema::hasColumn('users', 'password')) {
                    $table->string('password', 255)->after('email');
                }

                if(!Schema::hasColumn('users', 'remember_token')) {
                    $table->rememberToken();
                }

                if(!Schema::hasColumn('users', 'activated')) {
                    $table->boolean('activated')->after('remember_token')->default(false);
                }

                if(!Schema::hasColumn('users', 'activate_code')) {
                    $table->string('activate_code',255)->after('activated')->nullable();
                }

                if(!Schema::hasColumn('users', 'created_at')) {
                    $table->timestamp('created_at')->after('activate_code');
                }

                if(!Schema::hasColumn('users', 'updated_at')) {
                    $table->timestamp('updated_at')->after('created_at');
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