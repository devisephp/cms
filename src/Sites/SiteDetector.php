<?php

namespace Devise\Sites;

use Devise\Models\DvsSite;
use Illuminate\Support\Facades\Request;

class SiteDetector
{
  protected static $site;

  public function current()
  {
    if (self::$site)
    {
      return self::$site;
    }

    $domain = preg_replace('#^https?://#', '', Request::root());

    if (env('APP_ENV') !== 'production')
    {
      // let's try env params
      $allSites = DvsSite::all();
      foreach ($allSites as $site)
      {
        if ($domain === env('SITE_' . $site->id . '_DOMAIN'))
        {
          self::$site = $site;

          return $site;
        }
      }
    }

    $site = DvsSite::where('domain', $domain)
      ->first();

    if ($site)
    {
      self::$site = $site;

      return $site;
    }
  }
}