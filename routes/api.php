<?php

//us ing web & auth so the user's web session will persist through the api. may need our own middware if we ever switch between web and oauth
Route::group(['prefix' => 'api/devise', 'namespace' => 'Devise\Http\Controllers', 'middleware' => ['web','auth']], function () {


    /**
     * Fields
     */
    Route::put('fields/{field_id}', 'FieldsController@update');

    /**
     * Languages
     */
    Route::get('languages', 'LanguagesController@all');
    Route::post('languages', 'LanguagesController@store');
    Route::put('languages/{languages_id}', 'LanguagesController@update');

    /**
     * Media
     */
    Route::get('media/{folder_dot_path?}', 'MediaController@all');
    Route::get('searchable-media', 'MediaController@searchable');
    Route::post('media', 'MediaController@store');
    Route::delete('media/{media_route}', 'MediaController@remove')->where(['media_route' => '.*']);

    Route::post('media-styles', 'MediaController@generate');
    Route::put('media-styles/{instance_id}/{field_type}', 'MediaController@reGenerateAll');

    /**
     * Media Categories
     */
    Route::get('media-directories/{folder_dot_path?}', 'MediaDirectoriesController@all');
    Route::post('media-directories', 'MediaDirectoriesController@store');
    Route::delete('media-directories', 'MediaDirectoriesController@remove');

    /**
     * Meta
     */
    Route::get('meta', 'MetaController@all');
    Route::post('meta', 'MetaController@store');
    Route::put('meta/{meta_id}', 'MetaController@update');
    Route::delete('meta/{meta_id}', 'MetaController@delete');

    /**
     * Models
     */
    Route::get('models', 'ModelsController@all');
    Route::get('models/settings', 'ModelsController@settings');
    Route::get('models/query', 'ModelsController@query');

    /**
     * Mothership
     */
    Route::post('mothership/init', 'ReleasesController@init');

    Route::get('mothership/commit-hash', 'ReleasesController@commitHash');
    Route::get('mothership/pending-changes', 'ReleasesController@pendingChanges');

    Route::get('mothership/releases/{release_id}', 'ReleasesController@pull');
    Route::get('mothership/releases', 'ReleasesController@ids');

    Route::post('mothership/releases', 'ReleasesController@send');

    /**
     * Pages
     */
    Route::get('pages', 'PagesController@pages');
    Route::get('pagesList', 'PagesController@pagesList');
    Route::get('pages-suggest', 'PagesController@suggestList');
    Route::get('pages-vue-data/{page_id}', 'PagesController@getVueData');
    Route::post('pages', 'PagesController@store');
    Route::put('pages/{page_id}', 'PagesController@update');
    Route::put('pages/{page_id}/copy', 'PagesController@copy');
    Route::delete('pages/{page_id}', 'PagesController@delete');

    /**
     * Page Versions
     */
    Route::post('page-versions', 'PageVersionsController@copy');
    Route::put('page-versions/{page_version_id}', 'PageVersionsController@update');
    Route::put('page-versions/{page_version_id}/toggle-share', 'PageVersionsController@toggleSharing');
    Route::delete('page-versions/{page_version_id}', 'PageVersionsController@delete');

    /**
     * Redirects
     */
    Route::get('redirects', 'RedirectsController@all');
    Route::post('redirects', 'RedirectsController@store');
    Route::put('redirects/{redirect_id}', 'RedirectsController@update');
    Route::delete('redirects/{redirect_id}', 'RedirectsController@delete');

    /**
     * Sites
     */
    Route::get('sites', 'SitesController@all');
    Route::post('sites', 'SitesController@store');
    Route::put('sites/{sites_id}', 'SitesController@update');
    Route::delete('sites/{sites_id}', 'SitesController@delete');

    /**
     * Slices
     */
    Route::get('slices', 'SlicesController@all');
    Route::get('slices-directories', 'SlicesController@allDirectories');
    Route::post('slices', 'SlicesController@store');
    Route::put('slices/{slice_id}', 'SlicesController@update');
    Route::delete('slices/{slice_id}', 'SlicesController@delete');

    /**
     * Users
     */
    Route::get('users', 'UsersController@all');
    Route::post('users', 'UsersController@store');
    Route::put('users/{user_id}', 'UsersController@update');
    Route::delete('users/{user_id}', 'UsersController@delete');

});
