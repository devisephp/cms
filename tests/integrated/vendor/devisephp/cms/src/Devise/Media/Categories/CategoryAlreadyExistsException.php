<?php namespace Devise\Media\Categories;

/**
 * Class CategoryAlreadyExistsException is thrown
 * whenever the Categories/Manager finds a duplicate
 * category. (If you try to create the same directory)
 *
 * @package Devise\Media\Categories
 */
class CategoryAlreadyExistsException extends \Devise\Support\DeviseException
{
}