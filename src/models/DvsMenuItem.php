<?php

use Illuminate\Database\Eloquent\Model;

class DvsMenuItem extends Model
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
    if ($this->page)
    {

      if (\Route::getRoutes()->hasNamedRoute($this->page->route_name))
      {
        return route($this->page->route_name);
      } else
      {
        return $this->page->slug;
      }
    }

    return $value;
  }
}