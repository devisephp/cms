<?php namespace Devise\Support;

use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class DeviseHttpException should be the base class exception
 * for any exception thrown inside of Devise. This way we can
 * catch those specifically if we want and know that they are
 * different from just regular exceptions.
 *
 * @package Devise\Support
 */
class DeviseHttpException extends HttpException
{
    /**
     * Pretends to be a Facade for Exception
     *
     * @return DeviseHttpException
     */
    public static function getFacadeRoot()
    {
        return new self;
    }
}