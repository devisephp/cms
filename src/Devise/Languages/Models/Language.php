<?php

class Language extends Eloquent
{
    protected $table = 'dvs_languages';

    public function pages()
    {
        return $this->hasMany('Page');
    }

    public function getNameAttribute()
    {
		return $this->regional_human_name ?: $this->human_name;
    }
}