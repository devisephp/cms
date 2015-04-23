<?php namespace Devise\Pages\Interpreter\Exceptions;

/**
 * Thrown whenever the model tag has no picks, resulting
 * in a zero count mapping inside the TagManager
 */
class InvalidModelMappingException extends \Devise\Support\DeviseException
{

}