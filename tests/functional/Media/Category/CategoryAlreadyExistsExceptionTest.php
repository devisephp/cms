<?php namespace Devise\Media\Categories;

class CategoryAlreadyExistsExceptionTest extends \DeviseTestCase
{
    public function test_it_constructs()
    {
        new CategoryAlreadyExistsException;
    }
}