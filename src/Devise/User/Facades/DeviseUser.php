<?php namespace Devise\User\Facades;

use Illuminate\Support\Facades\Facade;

/**
* @see Devise\User\Helpers\UserHelper.php
*/
class DeviseUser extends Facade {

    /**
    * Get the registered name of the component.
    *
    * @return string
    */
    protected static function getFacadeAccessor() { return 'deviseuser'; }

}