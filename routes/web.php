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
  Route::get('/styled/{path}', 'Devise\Http\Controllers\MediaController@generate')->where('path', '.*');

});

/**
 * Templates
 */
Route::middleware(['web', 'auth'])->group(function () {

  Route::get('templates/{template_id}', 'Devise\Http\Controllers\TemplatesController@show');

});
