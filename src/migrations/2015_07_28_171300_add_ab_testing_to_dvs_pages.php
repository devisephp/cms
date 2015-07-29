<?php

use Illuminate\Database\Migrations\Migration;

class AddAbTestingToDvsPages extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('dvs_pages', function($table)
		{
			$table->boolean('ab_testing_enabled')->after('after')->default(false);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('dvs_pages', function($table)
		{
			$table->dropColumn('ab_testing_enabled');
		});
    }

}