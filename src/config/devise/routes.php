<?php return array(

	'enabled' => env('DEVISE_CACHE_ENABLED', false),

	'cache' => env('DEVISE_CACHE_PATH', storage_path() . '/framework/cache/devise-routes.php'),
);