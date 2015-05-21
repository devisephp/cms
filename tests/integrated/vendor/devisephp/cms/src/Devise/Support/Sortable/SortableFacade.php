<?php namespace Devise\Support\Sortable;

/**
 * Class SortableFacade
 * @package Devise\Support\Sortable
 */
class SortableFacade extends \Illuminate\Support\Facades\Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'devisesort'; }
}