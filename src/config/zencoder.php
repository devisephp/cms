<?php return array(

    /*
    |--------------------------------------------------------------------------
    | API key for zencoder
    |--------------------------------------------------------------------------
    |
    */
    'api-key' => '332351c28d280da718d20fbe73d15a2d',

    /*
    |--------------------------------------------------------------------------
    | If we are testing locally then we need some sort of
    | proxy url or else Zencoder cannot reach our development url
    | at http://localhost:8000/media/somefile.mov
    |--------------------------------------------------------------------------
    |
    */
	'callback-url' => url(),

    /*
    |--------------------------------------------------------------------------
    | Call back url for zencoder to tell us that our
    | video encoding job has been completed
    |--------------------------------------------------------------------------
    |
    */
    'notifications' => [ route('dvs-api-notifications-zencoder') ],

);