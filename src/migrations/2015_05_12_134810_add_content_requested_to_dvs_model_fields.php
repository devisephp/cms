<?php

use Illuminate\Database\Migrations\Migration;

class AddContentRequestedToDvsModelFields extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::table('dvs_model_fields', function($table)
		{
			$table->boolean('content_requested')->after('json_value')->default(false);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::table('dvs_model_fields', function($table)
		{
			$table->dropColumn('content_requested');
		});
    }

}