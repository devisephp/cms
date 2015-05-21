<?php namespace Devise\Pages\Interpreter\Exceptions;

/**
 * This exception is thrown anytime there are multiple devise
 * fields on a page that share the same key. Keys are unique to
 * the page.
 */
class DuplicateDeviseKeyException extends \Devise\Support\DeviseException
{
}