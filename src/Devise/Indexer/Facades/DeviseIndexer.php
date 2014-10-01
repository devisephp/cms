<?php namespace Devise\Indexer\Facades;

use Illuminate\Support\Facades\Facade;

class DeviseIndexer extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'deviseindexer'; }

}