<?php namespace Devise\Users\Permissions;

use Illuminate\Support\Facades\Facade;

/**
* @see \Devise\User\Permissions\RuleManager.php
*/
class RuleManagerFacade extends Facade
{
    /**
    * Get the registered name of the component.
    *
    * @return string
    */
    protected static function getFacadeAccessor() { return 'rulemanager'; }

}