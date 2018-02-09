<?php namespace Devise\Media\Categories;

use Exception;

/**
 * Class CategoryAlreadyExistsException is thrown
 * whenever the Categories/Manager finds a duplicate
 * category. (If you try to create the same directory)
 *
 * @package Devise\Media\Categories
 */
class CategoryAlreadyExistsException extends Exception
{
}