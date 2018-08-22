<?php

use Devise\Models\DvsSliceInstance;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MoveTemplateSlicesToSliceInstances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dvs_slice_instances', function (Blueprint $table) {
            $table->string('view')->after('template_slice_id');
            $table->string('type')->after('view');
            $table->string('label')->after('type');
            $table->text('model_query')->after('settings');
        });

        if (Schema::hasTable('dvs_template_slice'))
        {
            $slices = DB::table('dvs_template_slice')->get();
            $instances = DvsSliceInstance::get();
            foreach ($instances as $instance)
            {
                $slice = $slices->where('id', $instance->template_slice_id)
                    ->first();

                $instance->view = $slice->view;
                $instance->type = $slice->type;
                $instance->label = $slice->label;
                $instance->model_query = $slice->model_query;
                $instance->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dvs_slice_instances', function (Blueprint $table) {
            $table->dropColumn('view');
            $table->dropColumn('type');
            $table->dropColumn('label');
            $table->dropColumn('model_query');
            $table->dropColumn('config');
        });
    }
}
