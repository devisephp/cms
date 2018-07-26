<?php

namespace Devise\Models;

class DvsTemplate extends Model
{
    protected $fillable = ['name', 'layout', 'model_queries'];

    protected $table = 'dvs_templates';

    protected $attributes = [
        'model_queries' => '{}'
    ];

    public function pages()
    {
        return $this->hasMany(DvsPageVersion::class, 'template_id');
    }

    public function slices()
    {
        return $this->hasMany(DvsTemplateSlice::class, 'template_id')
            ->orderBy('position')
            ->where('parent_id', 0);
    }

    public function getModelQueriesAttribute($value)
    {
        return json_decode($value);
    }

    public function setModelQueriesAttribute($value)
    {
        $this->attributes['model_queries'] = ($value) ? json_encode($value) : '{}';
    }

}