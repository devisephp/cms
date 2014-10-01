<?php
// Route::filter('security', 'Devise\Data\Security\FormDataFilter');
// Route::when('*', 'security');

Route::any('dvs/store', array('as' => 'devise_data_store', 'uses' => 'DeviseStoreController@store'));
Route::any('dvs/{id}/update', array('as' => 'devise_data_update', 'uses' => 'DeviseStoreController@update'));