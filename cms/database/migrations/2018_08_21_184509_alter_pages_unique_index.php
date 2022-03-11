<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterPagesUniqueIndex extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dvs_pages', function(Blueprint $table){
            $table->unique(['route_name', 'site_id'], 'route_site_unique');
            $table->dropUnique('dvs_pages_route_name_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dvs_pages', function(Blueprint $table){
            $table->dropUnique('route_site_unique');
            $table->unique('route_name');
        });
    }
}
