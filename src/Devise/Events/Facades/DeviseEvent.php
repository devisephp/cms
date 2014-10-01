<?php namespace Devise\Events\Facades;

class DeviseEvent extends \Illuminate\Support\Facades\Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'deviseevent'; }

}