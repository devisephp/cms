<?php

/**
 * Pages
 */
App::make('Devise\Pages\RoutesGenerator')->loadRoutes();

/**
 * Templates
 */
Route::get('templates/{template_id}', 'Devise\Http\Controllers\TemplatesController@show')->middleware('auth');

Route::get('admin', 'Devise\Http\Controllers\AdminController@show');
