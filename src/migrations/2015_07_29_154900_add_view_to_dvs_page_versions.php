<?php

use Illuminate\Database\Migrations\Migration;

class AddViewToDvsPageVersions extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('dvs_page_versions', function($table)
		{
			$table->string('view')->after('name')->nullable();
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
			$table->dropColumn('view');
		});
    }

}