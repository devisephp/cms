<?php

namespace Devise\Sites;

use Devise\Models\DvsSite;
use Illuminate\Support\Facades\Request;

class SiteDetector
{
  protected static $site;

  protected static $allSites;

  public function all()
  {
    if (self::$allSites)
    {
      return self::$allSites;
    }

    $all = DvsSite::with('languages')->get();
    self::$allSites = $all;
    return $all;
  }

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
      $allSites = $this->all();
      foreach ($allSites as $site)
      {
        if ($domain === env('SITE_' . $site->id . '_DOMAIN'))
        {
          self::$site = $site;

          return $site;
        }
      }
    }

    $site = DvsSite::with('languages')
      ->where('domain', $domain)
      ->first();

    if ($site)
    {
      self::$site = $site;

      return $site;
    }
  }
}