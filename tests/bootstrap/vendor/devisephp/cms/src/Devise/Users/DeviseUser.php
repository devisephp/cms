<?php namespace Devise\Users;

use Illuminate\Support\Facades\Facade;

/**
* @see Devise\Users\UserHelper.php
*/
class DeviseUser extends Facade {

    /**
    * Get the registered name of the component.
    *
    * @return string
    */
    protected static function getFacadeAccessor() { return 'deviseuser'; }

}