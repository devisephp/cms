<?php

return [

  /*
  |--------------------------------------------------------------------------
  | Media
  |--------------------------------------------------------------------------
  |
  | Configuration for the media manager
  | See config/filesystems.php for media.driver options
  |
  */

  'media' => [
    'driver' => env('DVS_FILESYSTEM_DRIVER', 'public'),
    'root-directory' => 'media',
  ],

  /*
  |--------------------------------------------------------------------------
  | Mothership
  |--------------------------------------------------------------------------
  |
  | Configuration for mothership
  |
  */
  'mothership' => [
    'api-key' => env('MOTHERSHIP_API_KEY', null)
  ]
];
