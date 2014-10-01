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
			$table->integer('responsible_user_id')->unsigned();
            $table->string('name', 255);
            $table->string('stage');
            $table->longText('value');
			$table->softDeletes();
            $table->timestamps();

            $table->index('page_id');
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
        Schema::drop('dvs_page_versions');
	}

}
