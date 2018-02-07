<?php

Route::group(['prefix' => 'api/devise'], function () {

  /**
   * Media
   */
  Route::get('media/{folder_dot_path?}', 'MediaController@all');

  Route::post('media', 'MediaController@upload')
  ;
  Route::put('media', 'MediaController@rename');

  Route::delete('media', 'MediaController@remove');

  /**
   * Media Categories
   */
  Route::get('media/categories/{folder_dot_path?}', 'MediaCategoriesController@all');

  Route::post('media/categories', 'MediaCategoriesController@store');

  Route::put('media/categories', 'MediaCategoriesController@rename');

  Route::delete('media/categories', 'MediaCategoriesController@remove');

});