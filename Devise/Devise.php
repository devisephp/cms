<?php

namespace Devise;

use Devise\Http\Resources\Vue\PageResource;
use Devise\Http\Resources\Vue\SiteResource;
use Devise\Http\Resources\Vue\TemplateResource;
use Devise\Models\DvsPage;
use Devise\Models\DvsPageMeta;

use Devise\Sites\SiteDetector;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

use KgBot\LaravelLocalization\Facades\ExportLocalizations as LaravelLocalization;

/**
 * @todo refactor to a facade pattern
 */
class Devise
{
    private static $components = [];

    public static function head($page = null)
    {
        $head = '';
        $head .= self::analytics();
        $head .= self::meta($page);
        $head .= '<script>';
        $head .= self::data($page);
        $head .= '</script>';

        if (Auth::user())
        {
            $head .= '<link rel="stylesheet" href="' . mix('/css/devise.css', './devise/') . '">';
        }

        $head .= '<style>';
        $head .= '#devise-blocker { position:fixed; z-index:999999; top:0; left:0; right:0; bottom:0; background-color:white; 	pointer-events: none; transition:1s opacity; } #devise-blocker.fade { opacity:0; }';
        $head .= '</style>';

        return $head;
    }

    public static function analytics()
    {
        $analytics = '';
        $detector = App::make(SiteDetector::class);
        $currentSite = $detector->current();
        $settings = $currentSite->settings;


        if (isset($settings->googleAnalytics) && $settings->googleAnalytics !== '')
        {
            $analytics = '
      <script async src="https://www.googletagmanager.com/gtag/js?id=UA-72597741-1"></script>
      <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag(\'js\', new Date());

        gtag(\'config\', \'' . $settings->googleAnalytics . '\');
      </script>
      ';
        }

        return $analytics;
    }

    public static function meta($page = null)
    {
        $meta = '';
        if ($page && $page->canonical != null)
        {
            $meta .= '<link rel="canonical" href="' . $page->canonical . '">';
        }

        $globalMeta = DvsPageMeta::where('page_id', 0)->get();

        if ($page && $page->metas)
        {
            $page->metas = $page->metas->merge($globalMeta);

            foreach ($page->metas as $m)
            {
                $meta .= '<meta ' . $m->attribute_name . '="' . $m->attribute_value . '" content="' . $m->content . '">';
            }
        }

        return $meta;
    }

    public static function data($page)
    {
        $js = 'function Devise(){}';
        $js .= self::user();
        $js .= self::sites();
        $js .= self::lang();

        if (Auth::user())
        {
            $js .= self::mothership();
            $js .= self::interface();
        }

        if ($page)
        {
            $js .= self::pageData($page);
        }

        $js .= self::components();

        $js .= 'var deviseSettings = new Devise()';

        return $js;
    }

    public static function dataAsArray($page)
    {
        $resource = new PageResource($page);

        return [
            'page' => $resource->toArray(request())
        ];
    }

    public static function sites()
    {
        $detector = App::make(SiteDetector::class);
        $sites = $detector->all();

        $resource = SiteResource::collection($sites);

        return 'Devise.prototype.$sites = ' . json_encode($resource->toArray(request())) . ";\n";
    }

    public static function lang()
    {
        $locale = App::getLocale();
        $langs = LaravelLocalization::export()->toArray();
        $langs['locale'] = $locale;

        return 'Devise.prototype.$lang = ' . json_encode($langs[$locale]) . ";\n";
    }

    public static function getComponents()
    {
        return self::$components;
    }

    public static function components()
    {
        return 'Devise.prototype.$deviseComponents = {' . implode(',', self::$components) . "};\n";
    }

    public static function mothership()
    {
        return 'Devise.prototype.$mothership = ' . json_encode(config('devise.mothership')) . ";\n";
    }

    public static function interface()
    {
        return 'Devise.prototype.$interface = ' . json_encode(config('devise.interface')) . ";\n";
    }

    public static function pageData($page)
    {
        $resource = new PageResource($page);

        return 'Devise.prototype.$page = ' . json_encode($resource->toArray(request())) . ";\n";
    }

    public static function addComponent($slice)
    {
        $name = $slice->component_name;
        if (!isset(self::$components[$name]))
        {
            self::$components[$name] = $slice->component_code;
        }
    }

    public static function user()
    {
        return 'Devise.prototype.$user = ' . json_encode(Auth::user()) . ";\n";
    }

    public static function mothershipEnabled()
    {
        if (Schema::hasTable('dvs_releases') && config('devise.mothership.api-key')) return true;

        return false;
    }
}
