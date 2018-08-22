<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeSiteElementsToSiteLanguage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('dvs_site_element', 'dvs_site_language');

        DB::table('dvs_site_language')->where('element_type', '!=', 'Devise\Models\DvsLanguage')
            ->delete();

        Schema::table('dvs_site_language', function (Blueprint $table) {
            $table->dropColumn('element_type');
            $table->renameColumn('element_id', 'language_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('dvs_site_language', 'dvs_site_element');
    }
}
