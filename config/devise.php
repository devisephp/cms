<?php

return [

    /*
    |--------------------------------------------------------------------------
    | General
    |--------------------------------------------------------------------------
    |
    | General settings
    |
    */

    'mode' => env('DVS_MODE', 'install'),

    'cache_enabled' => env('DVS_CACHE_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | Layouts
    |--------------------------------------------------------------------------
    |
    | Array of available layouts for pages
    |
    */

    'layouts' => ['Main' => 'main'],

    /*
    |--------------------------------------------------------------------------
    | Media
    |--------------------------------------------------------------------------
    |
    | Configuration for the media manager
    | See config/filesystems.php for media.driver options
    |
    */

    'media'       => [
        'disk'                    => env('DVS_FILESYSTEM_DISK', 'public'),
        'cached-images-directory' => 'styled',
        'source-directory'        => 'media',
        'driver'                  => env('DVS_MEDIA_DRIVER', 'gd'), // imagick or gd
    ],

    /*
    |--------------------------------------------------------------------------
    | Mothership
    |--------------------------------------------------------------------------
    |
    | Configuration for mothership
    |
    */
    'mothership'  => [
        'url'     => env('MOTHERSHIP_URL', 'https://mothership.app/'),
        'api-key' => env('MOTHERSHIP_API_KEY', null)
    ],

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    |
    | Configuration for user permissions.
    | Available Permissions: ['access admin','manage pages','manage users','manage mothership',
    | 'manage settings','manage meta','manage sites','manage languages','manage redirects']
    |
    */
    'permissions' => [
        /*
        'example@email.com' => [
            'access admin',
            'manage pages',
            'manage users',
            'manage mothership',
            'manage settings',
            'manage meta',
            'manage sites',
            'manage languages',
            'manage redirects'
        ],
        */
        'default' => [
            'access admin',
            'manage pages',
            'manage users',
            'manage mothership',
            'manage settings',
            'manage meta',
            'manage sites',
            'manage languages',
            'manage redirects'
        ]
    ]
];