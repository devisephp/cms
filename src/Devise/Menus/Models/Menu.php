<?php

class Menu extends Eloquent
{
	protected $table = "dvs_menus";
	protected $guarded = array();

    public function language()
    {
        return $this->belongsTo('Language');
    }

    public function translatedFrom()
    {
        return $this->belongsTo('Menu', 'translated_from_menu_id');
    }


	public function items()
	{
		return $this->hasMany('MenuItem', 'menu_id')
			->where('parent_item_id', null)
			->orderBy('position', 'ASC');
	}

	public function allItems()
	{
		return $this->hasMany('MenuItem', 'menu_id')
            ->orderBy('parent_item_id', "ASC")
            ->orderBy('position', 'ASC');
	}
}