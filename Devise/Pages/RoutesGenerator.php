<?php namespace Devise\Pages;

use Devise\Http\Requests\Redirects\ExecuteRedirect;
use Devise\Support\Framework;
use Illuminate\Support\Facades\Schema;

class RoutesGenerator
{
    /**
     * [__construct description]
     */
    public function __construct(Framework $Framework)
    {
        $this->View = $Framework->View;
        $this->Config = $Framework->Config;
        $this->File = $Framework->File;
        $this->Request = $Framework->Request;
        $this->Route = $Framework->Route;
        $this->DB = $Framework->DB;
        $this->App = $Framework->Container;
        $this->Artisan = $Framework->Artisan;
    }

    /**
     * Loads the routes
     *
     */
    public function loadRoutes()
    {
        if ($this->pagesTableAvailable())
        {
            $routes = $this->findDvsPageRoutes();

            if ($routes->count())
            {
                $routesBySite = $routes->groupBy('site_id');
                $domains = $this->DB->table('dvs_sites')->pluck('domain', 'id');

                $this->setPageRoutes($routesBySite, $domains);

                $redirects = $this->findDvsRedirects();
                $redirectsBySite = $redirects->groupBy('site_id');

                $this->setRedirects($redirectsBySite, $domains);
            }
        }
    }

    private function setPageRoutes($routesBySite, $domains)
    {
        foreach ($routesBySite as $siteId => $routes)
        {
            if ($siteId > 0)
            {
                $overwrite = config('devise.domains.' . $siteId);
                $domainSettings = (!$overwrite) ? $domains[$siteId] : $overwrite;
                $domains = explode(',', $domainSettings);

                $callback = function () use ($routes) {

                    foreach ($routes as $route)
                    {
                        $uses = ['as' => $route->route_name, 'uses' => $route->uses];

                        if ($route->middleware)
                        {
                            $uses['middleware'] = explode('|', $route->middleware);
                        } else
                        {
                            $uses['middleware'] = 'web';
                        }

                        $this->Route->get($route->slug, $uses);
                    }

                };

                foreach ($domains as $domain)
                {
                    $this->Route->domain($domain)->group($callback);
                }
                
            } else
            {

                foreach ($routes as $route)
                {
                    $uses = ['as' => $route->route_name, 'uses' => $route->uses];

                    if ($route->middleware)
                    {
                        $uses['middleware'] = explode('|', $route->middleware);
                    } else
                    {
                        $uses['middleware'] = 'web';
                    }

                    $this->Route->get($route->slug, $uses);
                }
            }
        }
    }

    private function setRedirects($redirectsBySite, $domains)
    {
        foreach ($redirectsBySite as $siteId => $routes)
        {
            if ($siteId > 0)
            {
                $overwrite = env('SITE_' . $siteId . '_DOMAIN');
                $domain = (!$overwrite) ? $domains[$siteId] : $overwrite;
                $this->Route->group(['domain' => $domain], function () use ($routes) {

                    foreach ($routes as $route)
                    {
                        $this->Route->get($route->from_url, [
                            'uses' => 'Devise\Http\Controllers\RedirectsController@show',
                            'as'   => 'dvs-redirect-' . $route->id
                        ]);
                    }


                });
            } else
            {
                foreach ($routes as $route)
                {
                    $this->Route->get($route->from_url, [
                        'uses' => 'Devise\Http\Controllers\RedirectsController@show',
                        'as'   => 'dvs-redirect-' . $route->id
                    ]);
                }
            }
        }
    }

    /**
     * Returns the dvs page routes in this system
     *
     * @return array
     */
    protected function findDvsRedirects()
    {
        return $this->DB->table('dvs_redirects')->get();
    }

    /**
     * Returns the dvs page routes in this system
     *
     * @return array
     */
    protected function findDvsPageRoutes()
    {
        $pages = $this->DB->table('dvs_pages')
            ->select('slug', 'route_name', 'middleware', 'site_id')
            ->whereNull('deleted_at')
            ->get();

        foreach ($pages as $page)
        {
            // ensure that route slugs are all lower case
            $slugRegex = '/([^[\}]+)(?:$|\{)/';

            $page->slug = preg_replace_callback($slugRegex, function ($matches) {
                return strtolower($matches[0]);
            }, $page->slug, -1, $count);

            $page->uses = 'Devise\Http\Controllers\PagesController@show';
        }

        return $pages;
    }

    private function pagesTableAvailable()
    {
        try
        {
            return Schema::hasTable('dvs_pages');
        } catch (\Exception $e)
        {

        }

        return false;
    }
}