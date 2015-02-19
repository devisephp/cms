<?php

use Illuminate\Database\Migrations\Migration;

class AlterDvsMenuItemsToAddPermissions extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dvs_menu_items', function($table)
        {
            $table->string('permission')->nullable()->after('position');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dvs_menu_items', function($table)
        {
            $table->dropColumn('permission');
        });
    }

}