<?php

/*
|--------------------------------------------------------------------------
| Pages
|--------------------------------------------------------------------------
|
| Loading all pages and creating routes from slugs
| @todo need to implement route caching here for performance boost!
|
*/

if (!function_exists('loadDeviseRoutes'))
{
    function loadDeviseRoutes()
    {
        $filters = \Config::get('devise.permissions');
        $names = array_keys( $filters );

        foreach ($names as $name) {
            Route::filter($name, function($route, $request) use ($filters, $name) {
                $result = DeviseUser::checkConditions($name, true);
                if($result !== true){
                    if(!\Request::ajax()){
                        return $result;
                    } else {
                        App::abort(403, 'Unauthorized action.');
                    }
                }
            });
        }

        // LAST LINE OF DEFENSE: checks the route's before filters
        // against registered filters (Event::getListeners)
        // if the filter is not found 403 error will be thrown
        Route::filter('*', function($route, $request){
            $beforeFilters = $route->beforeFilters();
            foreach ($beforeFilters as $name => $value) {
                // because this filter is '*' every listener name is registered again
                // that's why it will be in there once if it doesn't exist anywhere else
                if(count(Event::getListeners('router.filter: ' . $name)) == 1){
                    App::abort(403, 'Unauthorized action.');
                }
            }
        });

        $pages = DB::table('dvs_pages')->select('http_verb','slug','route_name','before','after')->get();

        foreach ($pages as $page) {
            $slugRegex = '/([^[\}]+)(?:$|\{)/';

            $page->slug = preg_replace_callback($slugRegex, function ($matches) {
                return strtolower($matches[0]);
            }, $page->slug, -1, $count);

            $verb = $page->http_verb;

            $routeData = array(
                'as' => $page->route_name,
                'uses' => 'Devise\Pages\PageController@show',
            );

            if ($page->before) {
                $routeData['before'] = $page->before;
            }

            if ($page->after) {
                $routeData['after'] = $page->after;
            }

            Route::$verb($page->slug, $routeData);
        }

    }
}

if(!App::runningInConsole())
{
    try
    {
        loadDeviseRoutes();
    }
    catch (PDOException $e)
    {
        try
        {
            // this is a hack for people who use php artisan serve
            // and have not restarted their server yet, after an
            // install... for homestead users, this shouldn't be executed
            App::make('Devise\Support\Installer\InstallWizard')->refreshEnvironment();

            loadDeviseRoutes();
        }
        catch (PDOException $e)
        {
            if ( in_array($e->getCode(), array("1044", "1045", "1049", "42S02")) )
            {

                if (env('DEVISE_INSTALL') != 'ignore')
                {
                    Route::get('/', function() { return Redirect::to("/install/welcome"); });

                    // any route non containing string "install"
                    Route::any('{any?}', function() { return Redirect::to("/install/welcome"); })
                        ->where('any', '^((?!install).)*$');

                    Route::controller('install', 'Devise\Support\Installer\InstallerController');
                    return;
                }
            }

            throw $e;
        }
    }
}