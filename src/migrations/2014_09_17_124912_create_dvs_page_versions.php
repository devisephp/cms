<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDvsPageVersions extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('dvs_page_versions', function($table) {
            $table->increments('id');
			$table->integer('page_id')->unsigned();
			$table->integer('created_by_user_id')->unsigned();
            $table->string('name', 255);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
			$table->softDeletes();
            $table->timestamp('created_at')->default('0000-00-00 00:00:00');
            $table->timestamp('updated_at')->default('0000-00-00 00:00:00');
            $table->index('page_id');
            $table->index('created_by_user_id');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('dvs_page_versions');
	}

}
