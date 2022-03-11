<?php

use Devise\Models\DvsPageVersion;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dvs_page_versions', function (Blueprint $table) {
            $table->string('layout')->after('name');
        });

        if (Schema::hasTable('dvs_page_versions'))
        {
            $templates = DB::table('dvs_templates')->get();
            $versions = DvsPageVersion::get();
            foreach ($versions as $version)
            {
                $template = $templates->where('id', $version->template_id)
                    ->first();

                $version->layout = $template->layout;
                $version->save();
            }
        }

        Schema::drop('dvs_template_slice');

        Schema::drop('dvs_templates');

        Schema::table('dvs_slice_instances', function (Blueprint $table) {
            $table->dropColumn('template_slice_id');
        });

        Schema::table('dvs_page_versions', function (Blueprint $table) {
            $table->dropColumn('template_id');
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
            $table->unsignedInteger('template_id')->after('id');
            $table->dropColumn('layout');
        });

        Schema::create('dvs_template_slice', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('template_id')->unsigned();
            $table->integer('parent_id')->unsigned();
            $table->string('view');
            $table->string('type');
            $table->string('label');
            $table->integer('position')->unsigned();
            $table->text('model_query');
            $table->text('config');
            $table->timestamps();

            $table->index('template_id');
            $table->index('parent_id');
        });

        Schema::create('dvs_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('layout');
            $table->text('model_queries');
            $table->timestamps();
        });

        Schema::table('dvs_slice_instances', function (Blueprint $table) {
            $table->unsignedInteger('template_slice_id')->after('id');
        });
    }
}
