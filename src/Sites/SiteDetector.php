<?php

namespace Devise\Sites;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class SiteDetector
{
  protected static $siteId;

  /**
   * @return int
   */
  public static function getCurrentSiteId()
  {
    if (self::$siteId)
    {
      return self::$siteId;
    }

    $domain = preg_replace('#^https?://#', '', Request::root());

    $site = DB::table('sites')
      ->where('domains', 'LIKE', '%' . $domain . '%')
      ->first();

    return ($site) ? $site->id : 1;
  }
}