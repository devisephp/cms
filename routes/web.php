<?php

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