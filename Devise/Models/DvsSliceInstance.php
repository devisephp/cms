<?php

namespace Devise\Models;

use Devise\Traits\IsDeviseComponent;

class DvsSliceInstance extends Model
{
    use IsDeviseComponent;

    protected $fillable = ['page_version_id', 'parent_instance_id', 'view', 'label', 'position', 'settings', 'model_query'];

    protected $table = 'dvs_slice_instances';

    protected $touches = ['pageVersion'];

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

    public function setModelQueryAttribute($value)
    {
        $this->attributes['model_query'] = ($value) ? json_encode($value) : "";
    }

    public function getModelQueryAttribute($value)
    {
        return $value ? json_decode($value) : null;
    }

    public function getTypeAttribute()
    {
        return $this->has_model_query ? 'model' : 'single';
    }

    public function getHasModelQueryAttribute()
    {
        return ($this->model_query != '');
    }
}