<?php namespace Devise\Pages\Interpreter\Exceptions;

/**
 * Thrown whenever the page is not initialized with
 * correct data. This should never happen unless
 * we have bugs in our code...
 */
class PageDataNotInitializedException extends \Devise\Support\DeviseException
{

}