<?php

use \Eloquent;
use Devise\Fields\Models\FieldValue;

class Page extends Eloquent
{
   protected $guarded = array();

    protected $table = 'dvs_pages';

    public $createRules = array(
        'title'              => 'required|min:3',
        'slug'               => 'required|min:1',
        'http_verb'          => 'required|min:1'
    );

    public $updateRules = array(
        'title'              => 'min:1',
        'slug'               => 'min:1',
        'http_verb'          => 'required|min:1'
    );

    public $messages = array();

    public function versions()
    {
        return $this->hasMany('PageVersion');
    }

    public function localizedPages()
    {
        return $this->hasMany('Page', 'translated_from_page_id');
    }

    public function translatedFromPage()
    {
        return $this->belongsTo('Page', 'translated_from_page_id');
    }

    public function language()
    {
        return $this->belongsTo('Language');
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

    public function menuItems()
    {
        return $this->hasMany('MenuItem');
    }
}