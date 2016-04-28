<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterDvsPagesForMiddleware extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dvs_pages', function($table){
            $table->renameColumn('before', 'middleware');
            $table->dropColumn('after');
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
            $table->renameColumn('middleware', 'before');
            $table->text('after')->nullable()->after('before');
        });
    }
}
