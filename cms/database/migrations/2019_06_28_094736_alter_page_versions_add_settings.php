<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPageVersionsAddSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dvs_page_versions', function (Blueprint $table) {
            $table->text('settings')->after('ab_testing_amount')->nullable();
            $table->dropColumn('preview_hash');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dvs_page_versions', function (Blueprint $table) {
            $table->dropColumn('settings');
            $table->string('preview_hash', 255)->nullable()->after('ab_testing_amount');
        });
    }
}
