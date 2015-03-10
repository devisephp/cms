<?php

use Devise\Pages\Fields\FieldValue;
use Devise\Support\Sortable\Sortable;

class DvsPage extends Eloquent
{
    use Sortable;

    protected $guarded = array();

    protected $table = 'dvs_pages';

    public $createRules = array(
        'title'              => 'required|min:3',
        'slug'               => 'required|min:1',
        'http_verb'          => 'required|min:1',

        'response_path'      => 'required_if:response_type,Function|min:1',
        'response_params'    => 'required_if:response_type,Function|min:1',
    );

    public $updateRules = array(
        'title'              => 'min:1',
        'slug'               => 'min:1',
        'http_verb'          => 'required|min:1',

        'response_path'      => 'required|min:1',
        'response_params'    => 'required|min:1',
    );

    public $messages = array(
        'response_path.required_if' => 'The response path is required',
        'response_params.required_if' => 'The response parameters is required'
    );


    public function versions()
    {
        return $this->hasMany('DvsPageVersion', 'page_id');
    }

    public function localizedPages()
    {
        return $this->hasMany('DvsPage', 'translated_from_page_id');
    }

    public function translatedFromPage()
    {
        return $this->belongsTo('DvsPage', 'translated_from_page_id');
    }

    public function language()
    {
        return $this->belongsTo('DvsLanguage', 'language_id');
    }

    public function menuItems()
    {
        return $this->hasMany('DvsMenuItem', 'page_id');
    }

    public function getAttribute($key)
    {
        if ($this->hasAttribute($key))
        {
            return parent::getAttribute($key);
        }

        return in_array($key, ['softDelete']) ? null : new FieldValue('{}');
    }

    public function hasAttribute($key)
    {
         return array_key_exists($key, $this->attributes)
            or $this->hasGetMutator($key)
            or array_key_exists($key, $this->relations)
            or method_exists($this, camel_case($key));
    }

    public function getLiveVersion($now = null)
    {
        $now = $now ?: new DateTime;

        return $this->versions()
            ->where('starts_at', '<', $now)
            ->where(function($query) use ($now)
            {
                $query->where('ends_at', '>', $now);
                $query->orWhereNull('ends_at');
            })
            ->orderBy('starts_at', 'DESC')
            ->first();
    }

    public function setIsAdminAttribute($value)
    {
        if ($value === 'on' || $value === true || $value === 1) {
            $this->attributes['is_admin'] = 1;
        } else {
            $this->attributes['is_admin'] = 0;
        }
    }
}