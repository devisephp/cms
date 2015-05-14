<?php

use Illuminate\Database\Eloquent\Model;

class DvsMenu extends Model
{
	protected $table = "dvs_menus";
	protected $guarded = array();

    public function language()
    {
        return $this->belongsTo('DvsLanguage', 'language_id');
    }

    public function translatedFrom()
    {
        return $this->belongsTo('DvsMenu', 'translated_from_menu_id');
    }

	public function items()
	{
		return $this->hasMany('DvsMenuItem', 'menu_id')
			->where('parent_item_id', null)
			->orderBy('position', 'ASC');
	}

	public function allItems()
	{
		return $this->hasMany('DvsMenuItem', 'menu_id')
            ->orderBy('parent_item_id', "ASC")
            ->orderBy('position', 'ASC');
	}
}