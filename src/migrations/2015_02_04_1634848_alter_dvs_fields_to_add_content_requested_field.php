<?php

use Illuminate\Database\Migrations\Migration;

class AlterDvsFieldsToAddContentRequestedField extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dvs_fields', function($table)
        {
            $table->boolean('content_requested')->default(false)->after('json_value');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dvs_fields', function($table)
        {
            $table->dropColumn('content_requested');
        });
    }

}