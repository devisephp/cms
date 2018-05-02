<?php

/**
 * Pages
 */
App::make('Devise\Pages\RoutesGenerator')->loadRoutes();

/**
 * Templates
 */
Route::middleware(['web', 'auth'])->group(function () {

  Route::get('templates/{template_id}', 'Devise\Http\Controllers\TemplatesController@show');

});
