<?php

namespace Devise\Sites;

use Devise\Models\DvsSite;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;

class SiteDetector
{
    protected static $site;

    protected static $allSites;

    public function all()
    {
        if (config('devise.mode') === 'install') return collect([]);

        if (self::$allSites) return self::$allSites;

        $all = DvsSite::with('languages')->get();
        self::$allSites = $all;

        return $all;
    }

    public function current()
    {
        if (config('devise.mode') === 'install') return null;

        if (self::$site) return self::$site;

        $requested = preg_replace('#^https?://#', '', Request::root());


        $site = DvsSite::with('languages')
            ->where('domain', $requested)
            ->first();

        if ($site)
        {
            self::$site = $site;

            return $site;
        }

        if (config('devise.domain_overwrites_enabled', false))
        {
            // let's try overwrites
            $domains = config('devise.domains');
            foreach ($domains as $id => $domain)
            {
                $all = explode(',', $domain);
                foreach ($all as $d)
                {
                    if ($d == $requested)
                    {
                        return DvsSite::findOrFail($id);
                    }
                }
            }
        }
    }
}