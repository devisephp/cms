<?php

namespace Devise;

use DateTime;

use Devise\Http\Resources\Vue\PageResource;
use Devise\Http\Resources\Vue\SiteResource;
use Devise\Sites\SiteDetector;
use Devise\Support\Database;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

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

        if ($page)
            $head .= $page->head;

        $head .= '<style>';
        $head .= '#devise-blocker { position:fixed; z-index:999999; top:0; left:0; right:0; bottom:0; background-color:white; pointer-events: none; transition:1s opacity; } #devise-blocker.fade { opacity:0; }';
        $head .= '</style>';

        return $head;
    }

    public static function analytics()
    {
        $analytics = '';
        $detector = App::make(SiteDetector::class);
        $currentSite = $detector->current();

        if ($currentSite)
        {
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
        }

        return $analytics;
    }

    public static function meta($page = null)
    {
        $meta = '';
        if ($page) {
            $meta .= '<title>' . (($page->meta_title) ?: $page->title) . '</title>';

            if ($page->canonical != null) {
                $currentPath = request()->path();
                $currentDomain = request()->getHost();
                $canonPath = $page->canonical;
                $canonDomain = request()->getHost();

                $urlParts = parse_url($page->canonical);
                if (isset($urlParts['path'])) {
                    $canonPath = trim($urlParts['path'], '/');
                }
                if (isset($urlParts['host'])) {
                    $canonDomain = $urlParts['host'];
                }
                if ($currentPath != $canonPath || $currentDomain != $canonDomain) {
                    $meta .= '<link rel="canonical" href="' . $page->canonical . '">';
                }
            }

            if ($allMeta = $page->all_meta) {
                foreach ($allMeta as $m) {
                    $meta .= '<meta ' . $m->attribute_name . '="' . $m->attribute_value . '" content="' . $m->content . '">';
                }
            }
        }

        return $meta;
    }

    public static function data($page)
    {
        $js = 'function Devise(){}';
        $js .= self::user();
        $js .= self::lang();
        $js .= self::config();
        $js .= self::messages();

        if ($page)
        {
            $js .= self::pageData($page);
        }

        $js .= self::components();

        if (self::userAvailable())
        {
            $js .= self::sites();
        }

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
        $langs = LaravelLocalization::export()->toArray();
        $locale = App::getLocale();
        $langs[$locale]['locale'] = $locale;

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

    public static function messages()
    {
        $messages = [];

        $all = Session::all();
        foreach ($all as $key => $value)
        {
            if ($key == 'errors')
            {
                $errors = $value;

                if ($errors && $errors->any())
                {
                    $messages['errors'] = $errors->getBag('default')->toArray();
                }
            }
            if ($key === 'dvs-messages')
            {
                foreach ($value as $messageKey => $message)
                {
                    $messages[$messageKey] = $message;
                }
            }
        }

        return 'Devise.prototype.$messages = ' . json_encode($messages) . ";\n";
    }

    public static function config()
    {
        $data['layouts'] = config('devise.layouts');
        $data['mode'] = config('devise.mode');

        if (self::userAvailable())
        {
            $data['additionalSiteSettings'] = config('devise.additionalSiteSettings');
            $data['additionalPageSettings'] = config('devise.additionalPageSettings');
        }

        return 'Devise.prototype.$config = ' . json_encode($data) . ";\n";
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
        if (self::userAvailable())
        {
            return 'Devise.prototype.$user = ' . json_encode(Auth::user()) . ";\n";
        }

        return "Devise.prototype.\$user = null;\n";
    }

    public static function userAvailable()
    {
        return Auth::check();
    }

    public static function currentDateTime()
    {
        $now = new DateTime;

        if (request()->has('time_travel_to') && Auth::check())
        {
            $user = Auth::user();
            if ($user->hasPermission('manage pages'))
            {
                $now->setTimestamp(strtotime(request()->get('time_travel_to')));
            }
        }

        return $now;
    }
}