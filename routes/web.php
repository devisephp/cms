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
    Route::middleware(['web', 'auth'])->group(function () {

        Route::get('/styled/preview/{path}', 'Devise\Http\Controllers\MediaController@preview')->where('path', '.*');

    });
} else {
    Route::get('{any}', function () {

        $data = [
            'env' => \Illuminate\Support\Facades\App::environment()
        ];

        return view('devise::install-checklist', $data);

    })->where('any', '.*');
}