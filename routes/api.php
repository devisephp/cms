<?php

Route::group(['prefix' => 'api/devise', 'namespace' => 'Devise\Http\Controllers'], function () {

  /**
   * Media
   */
  Route::get('media/{folder_dot_path?}', 'MediaController@all');
  Route::post('media', 'MediaController@store');
  Route::delete('media/{media_id}', 'MediaController@remove');

  /**
   * Media Categories
   */
  Route::get('media-directories/{folder_dot_path?}', 'MediaDirectoriesController@all');
  Route::post('media-directories', 'MediaDirectoriesController@store');
  Route::delete('media-directories', 'MediaDirectoriesController@remove');

  /**
   * Pages
   */
  Route::post('pages', 'PagesController@store');

  /**
   * Slices
   */
  Route::get('slices', 'SlicesController@all');
  Route::post('slices', 'SlicesController@store');
  Route::put('slices/{slice_id}', 'SlicesController@update');
  Route::delete('slices/{slice_id}', 'SlicesController@delete');

  /**
   * Templates
   */
  Route::get('templates', 'TemplatesController@all');
  Route::post('templates', 'TemplatesController@store');
  Route::put('templates/{template_id}', 'TemplatesController@update');
  Route::delete('templates/{template_id}', 'TemplatesController@delete');

});