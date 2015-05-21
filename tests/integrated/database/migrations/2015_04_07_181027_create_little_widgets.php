<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLittleWidgets extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('little_widgets', function($table) {
                $table->increments('id');
                $table->string('title', 100);
                $table->string('author_of_the_article');
                $table->timestamp('deleted_at')->nullable();
                $table->timestamp('created_at')->default('0000-00-00 00:00:00');
                $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
                $table->index('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('little_widgets');
    }

}