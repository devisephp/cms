<?php

namespace Devise\Models;

use Devise\Sites\SiteDetector;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class DvsSite extends Model
{
  use SoftDeletes;

  public $fillable = array('name', 'domain', 'settings');

  protected $table = 'dvs_sites';

  public function languages()
  {
    return $this->morphedByMany(DvsLanguage::class, 'element', 'dvs_site_element', 'site_id')
      ->withPivot('default');
  }

  public function getCurrentAttribute()
  {
    $detector = App::make(SiteDetector::class);

    $site = $detector->current();

    return ($site->id === $this->id);
  }

  public function getDefaultLanguageAttribute()
  {
    return $this->languages()
      ->wherePivot('default', 1)
      ->first();
  }

  public function getSettingsAttribute($value)
  {
    return json_decode($value);
  }

  public function setSettingsAttribute($value)
  {
    $this->attributes['settings'] = ($value) ? json_encode($value) : '{}';
  }
}