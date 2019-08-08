<?php

if (config('devise.mode') !== 'install')
{
    /**
     * Pages
     */
    App::make('Devise\Pages\RoutesGenerator')->loadRoutes();

    /**
     * Media
     */
    Route::get('/styled/preview/{path}', 'Devise\Http\Controllers\MediaController@preview')
        ->where('path', '.*')->middleware(['web', 'auth']);

    Route::get('/storage/styled/{path}', 'Devise\Http\Controllers\MediaController@show')
        ->where('path', '.*')->middleware('web');

    Route::get('sitemap.xml', 'Devise\Http\Controllers\SeoController@sitemap');

    Route::get('sitemap.json', 'Devise\Http\Controllers\SeoController@sitemapJson');

} else
{
    Route::get('{any}', function () {

        $data = [
            'env' => \Illuminate\Support\Facades\App::environment()
        ];

        return view('devise::install-checklist', $data);

    })->where('any', '^((?!api).)*$')->middleware('web');
}