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
  Route::get('media/directories/{folder_dot_path?}', 'MediaDirectoriesController@all');
  Route::post('media/directories', 'MediaDirectoriesController@store');
  Route::delete('media/directories', 'MediaDirectoriesController@remove');

  /**
   * Slices
   */
  Route::get('slices', 'SlicesController@all');

  /**
   * Templates
   */
  Route::get('templates', 'TemplatesController@all');
  Route::post('templates', 'TemplatesController@store');
  Route::put('templates/{template_id}', 'TemplatesController@update');
  Route::delete('templates/{template_id}', 'TemplatesController@delete');

});