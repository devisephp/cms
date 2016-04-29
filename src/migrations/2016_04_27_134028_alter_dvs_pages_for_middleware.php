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
            Schema::table('dvs_pages', function($table)
            {
                $table->text('middleware')->nullable()->after('footer');
            });
            
            $this->copyData('before', 'middleware');

            Schema::table('dvs_pages', function($table)
            {
                $table->dropColumn('before');
            });
            Schema::table('dvs_pages', function($table)
            {
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
            $table->text('before')->nullable()->after('footer');
        });
        
        Schema::table('dvs_pages', function($table)
        {
            $table->text('after')->nullable()->after('before');
        });

        $this->copyData('middleware', 'before');

        Schema::table('dvs_pages', function($table)
        {
            $table->dropColumn('middleware');
        });
    }

    private function copyData($from, $to)
    {
        $pagesWithBefore = \DB::table('dvs_pages')
                                ->select('id',$from)
                                ->get();

        foreach ($pagesWithBefore as $page) {
            \DB::table('dvs_pages')
                ->where('id',$page->id)
                ->update([
                    $to => $page->before
                ]);
        }
    }
}
