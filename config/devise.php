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

    'mode'                      => env('DVS_MODE', 'install'),
    'cache_enabled'             => env('DVS_CACHE_ENABLED', false),
    'model_cache_ignores' => env('DVS_MODEL_CACHE_IGNORES', null),

    /*
    |--------------------------------------------------------------------------
    | Domain Overwrites
    |--------------------------------------------------------------------------
    |
    | Allows the overwriting of the dvs_site domains with local or staging domains
    | The ID if the dvs_sites entry should be the key of each domain item
    |
    */
    'domain_overwrites_enabled' => env('DVS_DOMAIN_OVERWRITES_ENABLED', false),
    'domains'                   => [
        1 => env('SITE_1_DOMAIN', 'localdomain.test'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    */
    'register_redirects_first' => env('DVS_REGISTER_REDIRECTS_FIRST', true),

    /*
    |--------------------------------------------------------------------------
    | Layouts
    |--------------------------------------------------------------------------
    |
    | Array of available layouts for pages
    |
    */

    'layouts' => ['Main' => 'layouts.main'],

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
        'security'                => [
            'key' => env('APP_KEY'),
        ],
        'disk'                    => env('DVS_FILESYSTEM_DISK', 'public'),
        'cached-images-directory' => 'styled',
        'source-directory'        => 'media',
        'image-alts-directory'    => 'alts',
        'driver'                  => env('DVS_MEDIA_DRIVER', 'gd'), // imagick or gd
        'default-settings'                => [
            'q'     => 80,
            'fit'   => 'crop',
            'sharp' => 5
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Permissions
    |--------------------------------------------------------------------------
    |
    | Configuration for user permissions.
    | Available Permissions: ['access admin','manage pages','manage users'
    | 'manage settings','manage meta','manage sites','manage languages','manage redirects']
    |
    */
    'permissions' => [
        /*
        'example@email.com' => [
            'access admin',
            'manage pages',
            'manage slices',
            'manage users',
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
            'manage slices',
            'manage users',
            'manage settings',
            'manage meta',
            'manage sites',
            'manage languages',
            'manage redirects',
            'manage media'
        ]
    ]
];