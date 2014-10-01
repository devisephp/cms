<?php namespace Devise\Models\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Lbm\Devise\Helpers\DeviseForm
 */
class DeviseForm extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'deviseform'; }

}