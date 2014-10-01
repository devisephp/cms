<?php
return array(

    /*
    |--------------------------------------------------------------------------
    | Root directory of the media manager inside the public directory
    |--------------------------------------------------------------------------
    |
    */

    'root-dir' => 'media',


    /*
    |--------------------------------------------------------------------------
    | the string used to demarcate a file as a media manager thumbnail
    | example: an image name "awesome.png"
    |          the thumbnail's name "awesome.dvs-thumb.png"
    |--------------------------------------------------------------------------
    |
    */

    'thumb-key' => 'dvs-thumb',
    'crop-key' => 'dvs-crop',

    /*
    |--------------------------------------------------------------------------
    | Default thumbnails by file extension
    |--------------------------------------------------------------------------
    |
    */

    'thumbs' => [
        'file' => 'packages/devise/cms/img/meda-manager-default-thumb.png',
        'png' => 'packages/devise/cms/img/meda-manager-default-thumb.png',
        'jpeg' => 'packages/devise/cms/img/meda-manager-default-thumb.png',
        'jpg' => 'packages/devise/cms/img/meda-manager-default-thumb.png',
        'gif' => 'packages/devise/cms/img/meda-manager-default-thumb.png',
        'xls' => 'packages/devise/cms/img/meda-manager-default-thumb.png',
        'doc' => 'packages/devise/cms/img/meda-manager-default-thumb.png',
        'docx' => 'packages/devise/cms/img/meda-manager-default-thumb.png',
        'zip' => 'packages/devise/cms/img/meda-manager-default-thumb.png',
        'js' => 'packages/devise/cms/img/meda-manager-default-thumb.png',
    ]
);
