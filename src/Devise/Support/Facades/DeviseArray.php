<?php namespace Devise\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Lbm\DeviseSupport\Helpers\ArrayHelper.php
 */
class DeviseArray extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'devisearray'; }

}