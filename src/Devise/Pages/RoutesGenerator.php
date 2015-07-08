<?php namespace Devise\Pages;

use Devise\Support\Framework;
use Devise\Users\DeviseUser;

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
     * This will load devise routes in case
     *
     * @return [type]
     */
    public function loadFilters()
    {
        $filters = $this->Config->get('devise.permissions');

        $names = array_keys( $filters );

        foreach ($names as $name)
        {
            $this->Route->filter($name, function($route, $request) use ($filters, $name)
            {
                $result = DeviseUser::checkConditions($name, true);

                if ($result !== true)
                {
                    if (!$this->Request->ajax())
                    {
                        return $result;
                    }
                    else
                    {
                        $this->App->abort(403, 'Unauthorized action.');
                    }
                }
            });
        }
    }

    /**
     * Loads the routes
     *
     * @return [type]
     */
    public function loadRoutes()
    {
        if ($this->routesAreCached()) return;

        $routes = $this->findDvsPageRoutes();

        foreach ($routes as $route)
        {
            $verb = $route->http_verb;
            $uses = ['as' => $route->route_name, 'uses' => $route->uses ];

            if ($route->before) $uses['before'] = $route->before;
            if ($route->after) $uses['after'] = $route->after;

            $this->Route->$verb($route->slug, $uses);
        }
    }

    /**
     * Uses the routes array and spits out
     * a string of laravel routes
     *
     * @param  array  $routes
     * @param  string $filename
     * @return string
     */
    public function cacheRoutes()
    {
        $routeCachePath = $this->Config->get('devise.routes.cache');

        $routes = $this->findDvsPageRoutes();

        $routesAsString = $this->View->make('devise::layouts.routes', ['routes' => $routes])->render();

        $this->File->put($routeCachePath, $routesAsString);

        $this->Artisan->call('route:cache');
    }

    /**
     * Are the routes cached or not?
     *
     * @return [type]
     */
    protected function routesAreCached()
    {
        $routeCachePath = $this->Config->get('devise.routes.cache');

        return $this->File->exists($routeCachePath);
    }

    /**
     * Returns the dvs page routes in this system
     *
     * @return array
     */
    protected function findDvsPageRoutes()
    {
        $pages = $this->DB->table('dvs_pages')->select('http_verb','slug','route_name','before','after')->get();

        foreach ($pages as $page)
        {
            // ensure that route slugs are all lower case
            $slugRegex = '/([^[\}]+)(?:$|\{)/';

            $page->slug = preg_replace_callback($slugRegex, function ($matches) {
                return strtolower($matches[0]);
            }, $page->slug, -1, $count);

            $page->uses = 'Devise\Pages\PageController@show';
        }

        return $pages;
    }
}