<?php namespace Devise\Pages\Fields;

/**
 * Whenever we see a duplicate field key on a page
 * throw an exception for the developer so they can fix it.
 */
class DuplicateFieldKeyException extends \Devise\Support\DeviseException
{

}