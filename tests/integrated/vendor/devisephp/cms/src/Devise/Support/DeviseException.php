<?php namespace Devise\Support;

/**
 * Class DeviseException should be the base class exception
 * for any exception thrown inside of Devise. This way we can
 * catch those specifically if we want and know that they are
 * different from just regular exceptions.
 *
 * @package Devise\Support
 */
class DeviseException extends \Exception
{
    /**
     * Pretends to be a Facade for Exception
     *
     * @return DeviseException
     */
    public static function getFacadeRoot()
    {
        return new self;
    }
}