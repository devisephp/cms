<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDvsSliceInstancesAddSettingsDropEnabled extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dvs_slice_instances', function (Blueprint $table) {
            $table->dropColumn('enabled');
            $table->text('settings')->after('position');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dvs_slice_instances', function (Blueprint $table) {
            $table->boolean('enabled');
            $table->dropColumn('settings');
        });
    }
}
