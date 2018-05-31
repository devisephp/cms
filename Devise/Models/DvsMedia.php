<?php

namespace Devise\Models;

use Devise\Sites\SiteDetector;
use Illuminate\Support\Facades\App;

class DvsMedia extends Model
{
  public $table = 'dvs_media';

  public function getMediaPathAttribute($value)
  {
    $siteDetector = App::make(SiteDetector::class);
    $site = $siteDetector->current();

    if ($this->directory == "")
    {
      return '/media/' . $site->domain . '/' . $this->name;
    }

    return '/media/' . $site->domain . '/' . $this->directory . '/' . $this->name;
  }
}