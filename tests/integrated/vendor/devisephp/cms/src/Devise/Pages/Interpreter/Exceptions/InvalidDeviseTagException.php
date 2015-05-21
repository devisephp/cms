<?php namespace Devise\Pages\Interpreter\Exceptions;

/**
 * Thrown whenever the devise tag is malformed.
 * For example, if you don't pass required fields to
 * data-devise="key, type" then in that case we throw
 * this exception
 */
class InvalidDeviseTagException extends \Devise\Support\DeviseException
{

}