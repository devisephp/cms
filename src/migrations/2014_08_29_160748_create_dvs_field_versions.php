<?php

use Illuminate\Database\Migrations\Migration;

class CreateDvsFieldVersions extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dvs_field_versions', function($table) {
            $table->increments('id');
            $table->integer('collection_instance_id')->nullable();
            $table->integer('field_id');
            $table->integer('responsible_user_id')->nullable();
            $table->string('stage', 255);
            $table->text('value');
            $table->dateTime('published_at')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->dateTime('deleted_at');

            $table->index('collection_instance_id');
            $table->index('field_id');
            $table->index('responsible_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dvs_field_versions');
    }

}