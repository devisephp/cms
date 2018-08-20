<?php

namespace Devise\Models;

use Devise\Traits\IsDeviseComponent;

class DvsSliceInstance extends Model
{
    use IsDeviseComponent;

    protected $fillable = ['page_version_id', 'parent_instance_id', 'enabled', 'position'];

    protected $table = 'dvs_slice_instances';

    public $parent_type = 'single';

    public function pageVersion()
    {
        return $this->belongsTo(DvsPageVersion::class, 'page_version_id');
    }

    public function slices()
    {
        return $this->hasMany(DvsSliceInstance::class, 'parent_instance_id')
            ->orderBy('position');
    }

    public function fields()
    {
        return $this->hasMany(DvsField::class, 'slice_instance_id');
    }

    public function setSettingsAttribute($value)
    {
        $this->attributes['settings'] = ($value) ? json_encode($value) : "";
    }

    public function getSettingsAttribute($value)
    {
        $json = $value ?: '{}';

        return json_decode($json);
    }
}