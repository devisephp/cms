<?php namespace Devise\Pages;

use Devise\Support\DeviseException;

/**
 * This exception is thrown whenever the page is not found
 * in the database (likely because the page is not published)
 */
class PageNotFoundException extends DeviseException
{

}