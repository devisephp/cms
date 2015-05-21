<?php

class DvsMenuItem extends Eloquent
{
	protected $table = "dvs_menu_items";
	protected $guarded = array();

    public function items()
    {
        return $this->hasMany('DvsMenuItem', 'parent_item_id')
            ->orderBy('position', 'ASC');
    }

    public function children()
    {
        return $this->hasMany('DvsMenuItem', 'parent_item_id')
            ->orderBy('position', 'ASC');
    }

    public function parent()
    {
        return $this->belongsTo('DvsMenuItem', 'parent_item_id')
            ->orderBy('position', 'ASC');
    }

    public function page()
    {
        return $this->belongsTo('DvsPage', 'page_id');
    }

    public function getUrlAttribute($value)
    {
        if(isset($this->page->slug)) {
            return $this->page->slug;
        }

        return $value;
    }
}