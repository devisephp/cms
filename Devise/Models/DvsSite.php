<?php

namespace Devise\Models;

use Devise\Sites\SiteDetector;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class DvsSite extends Model
{
  protected $guarded = array();

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
    $lang = $this->languages()
      ->wherePivot('default', 1)
      ->first();

    return $lang;
  }
}