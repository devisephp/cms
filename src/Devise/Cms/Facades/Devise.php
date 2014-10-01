<?php namespace Devise\Cms\Facades;

use Illuminate\Support\Facades\Facade;

class Devise extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'devisecms'; }
}