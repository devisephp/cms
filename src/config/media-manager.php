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
        'file' => '/packages/devisephp/cms/img/meda-manager-default-thumb.png',
        'png' => '/packages/devisephp/cms/img/meda-manager-default-thumb.png',
        'jpeg' => '/packages/devisephp/cms/img/meda-manager-default-thumb.png',
        'jpg' => '/packages/devisephp/cms/img/meda-manager-default-thumb.png',
        'gif' => '/packages/devisephp/cms/img/meda-manager-default-thumb.png',
        'xls' => '/packages/devisephp/cms/img/meda-manager-default-thumb.png',
        'doc' => '/packages/devisephp/cms/img/meda-manager-default-thumb.png',
        'docx' => '/packages/devisephp/cms/img/meda-manager-default-thumb.png',
        'zip' => '/packages/devisephp/cms/img/meda-manager-default-thumb.png',
        'js' => '/packages/devisephp/cms/img/meda-manager-default-thumb.png',
    ]
);
