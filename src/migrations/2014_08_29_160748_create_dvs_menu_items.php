<?php

use Illuminate\Database\Migrations\Migration;

class CreateDvsMenuItems extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dvs_menu_items', function($table) {
            $table->increments('id');
            $table->integer('menu_id')->unsigned();
            $table->integer('parent_item_id')->nullable()->unsigned();
            $table->string('name', 255);
            $table->integer('page_id')->nullable()->unsigned();
            $table->string('url', 255);
            $table->string('image');
            $table->text('description');
            $table->integer('position')->default('0');
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');

            $table->index('menu_id');
            $table->index('page_id');
            $table->index('parent_item_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('dvs_menu_items');
    }

}