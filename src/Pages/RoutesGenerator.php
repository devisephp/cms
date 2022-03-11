<?php namespace Devise\Pages;

use Devise\Sites\SiteDetector;
use Devise\Support\Framework;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Schema;

class RoutesGenerator
{
    /**
     * @var SiteDetector
     */
    private $SiteDetector;

    /**
     * [__construct description]
     */
    public function __construct(SiteDetector $SiteDetector, Framework $Framework)
    {
        $this->SiteDetector = $SiteDetector;
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
        if ($this->pagesTableAvailable()) {
            $routes = $this->findDvsPageRoutes();

            if ($routes->count()) {
                $routesBySite = $routes->groupBy('site_id');
                $domains = $this->DB->table('dvs_sites')->pluck('domain', 'id');
                $redirectsBySite = $this->getRedirectsBySite();

                if (config('devise.register_redirects_first')) {
                    $this->setRedirects($redirectsBySite, $domains);
                    $this->setPageRoutes($routesBySite, $domains);
                } else {
                    $this->setPageRoutes($routesBySite, $domains);
                    $this->setRedirects($redirectsBySite, $domains);
                }
            }
        }
    }

    private function setPageRoutes($routesBySite, $siteDomains)
    {
        $overwritesEnabled = config('devise.domain_overwrites_enabled', false);

        if ($overwritesEnabled) {
            $currentDomain = Request::getHost();
        }

        foreach ($routesBySite as $siteId => $routes) {
            if ($siteId > 0) {
                $domainSettings = $siteDomains[$siteId];

                if ($overwritesEnabled) {
                    $overwrites = config('devise.domains.' . $siteId, null);
                    if ($overwrites) {
                        if (strpos($overwrites, $currentDomain) !== false) {
                            $overwrites = $currentDomain;
                        }
                        $domainSettings = $overwrites;
                    }
                }

                $domains = explode(',', $domainSettings);

                foreach ($domains as $domain) {
                    $this->Route->domain($domain)->group(
                        function () use ($routes, $siteId) {
                            foreach ($routes as $route) {
                                $uses = ['as' => $route->route_name, 'uses' => $route->uses];

                                if ($route->middleware) {
                                    $uses['middleware'] = explode('|', $route->middleware);
                                } else {
                                    $uses['middleware'] = 'web';
                                }

                                $this->Route->get($route->slug, $uses);
                            }
                        }
                    );
                }
            } else {
                foreach ($routes as $route) {
                    $uses = ['as' => $route->route_name, 'uses' => $route->uses];

                    if ($route->middleware) {
                        $uses['middleware'] = explode('|', $route->middleware);
                    } else {
                        $uses['middleware'] = 'web';
                    }

                    $this->Route->get($route->slug, $uses);
                }
            }
        }
    }

    private function setRedirects($redirectsBySite, $allDomains)
    {
        foreach ($redirectsBySite as $siteId => $routes) {
            if ($siteId > 0) {
                $overwrite = config('devise.domains.' . $siteId);
                $overwritesEnabled = config('devise.domain_overwrites_enabled');
                $siteDomains = (!$overwritesEnabled || !$overwrite) ? [$allDomains[$siteId]] : explode(',', $overwrite);
                foreach ($siteDomains as $dIndex => $domain) {
                    $this->Route->group(
                        ['domain' => $domain],
                        function () use ($routes, $siteId, $dIndex) {
                            foreach ($routes as $route) {
                                $this->Route->get(
                                    $route->from_url,
                                    [
                                        'uses' => 'Devise\Http\Controllers\RedirectsController@show',
                                        'as' => 'dvs-redirect-' . $route->id . '-' . $siteId . '-' . $dIndex
                                    ]
                                );
                            }
                        }
                    );
                }
            } else {
                foreach ($routes as $route) {
                    $this->Route->get(
                        $route->from_url,
                        [
                            'uses' => 'Devise\Http\Controllers\RedirectsController@show',
                            'as' => 'dvs-redirect-' . $route->id
                        ]
                    );
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

        foreach ($pages as $page) {
            // ensure that route slugs are all lower case
            $slugRegex = '/([^[\}]+)(?:$|\{)/';

            $page->slug = preg_replace_callback(
                $slugRegex,
                function ($matches) {
                    return strtolower($matches[0]);
                },
                $page->slug,
                -1,
                $count
            );

            $page->uses = 'Devise\Http\Controllers\PagesController@show';
        }

        return $pages;
    }

    private function pagesTableAvailable()
    {
        try {
            return Schema::hasTable('dvs_pages');
        } catch (\Exception $e) {
        }

        return false;
    }

    protected function getRedirectsBySite()
    {
        $redirects = $this->findDvsRedirects();
        return $redirects->groupBy('site_id');
    }
}