<?php

use Illuminate\Database\Migrations\Migration;

class AddAbTestingToDvsPageVersions extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('dvs_page_versions', function($table)
		{
			$table->integer('ab_testing_amount')->after('ends_at')->default(0);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('dvs_page_versions', function($table)
		{
			$table->dropColumn('ab_testing_enabled');
		});
    }

}