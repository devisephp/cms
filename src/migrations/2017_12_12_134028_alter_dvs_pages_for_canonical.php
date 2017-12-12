<?php
wdfasdfasdfasdfasdasdfsdfa
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDvsPagesForCanonical extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dvs_pages', function($table)
        {
            $table->string('canonical')->nullable()->after('meta_keywords');
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
            $table->dropColumn('canonical');
        });
    }
}
