<?php

try
{
    App::make('Devise\Pages\RoutesGenerator')->loadFilters();
    App::make('Devise\Pages\RoutesGenerator')->loadRoutes();
}
catch (PDOException $e)
{
    try
    {
        // this is a hack for people who use php artisan serve
        // and have not restarted their server yet, after an
        // install... for homestead users, this shouldn't be executed
        App::make('Devise\Support\Installer\InstallWizard')->refreshEnvironment();
        App::make('Devise\Pages\RoutesGenerator')->loadRoutes();
    }
    catch (PDOException $e)
    {
        if ( in_array($e->getCode(), array("1044", "1045", "1049", "42S02", "HY000")) )
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