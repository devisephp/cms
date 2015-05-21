<?php namespace Devise\Pages\Interpreter\Exceptions;

/**
 * This exception is thrown anytime the devise key is
 * invalid. A invalid variable name in php is considered
 * an invalid key name. We have to use key name in
 * php to referrence the devise key, i.e. $keyName->text
 */
class InvalidDeviseKeyException extends \Devise\Support\DeviseException
{

}