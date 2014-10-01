<?php

class MenuItem extends Eloquent
{
	protected $table = "dvs_menu_items";
	protected $guarded = array();

    public function items()
    {
        return $this->hasMany('MenuItem', 'parent_item_id')
            ->orderBy('position', 'ASC');
    }

    public function children()
    {
        return $this->hasMany('MenuItem', 'parent_item_id')
            ->orderBy('position', 'ASC');
    }

    public function parent()
    {
        return $this->belongsTo('MenuItem', 'parent_item_id')
            ->orderBy('position', 'ASC');
    }

    public function page()
    {
        return $this->belongsTo('Page');
    }

    public function getUrlAttribute($value)
    {
        if(isset($this->page->slug)) {
            return $this->page->slug;
        }

        return $value;
    }
}