<?php namespace Devise\MediaManager\Categories;

use Devise\MediaManager\Categories\Manager as CategoryManager;
use Redirect, Session;

class ResponseHandler
{
    protected $CategoryManager;
    protected $config;

    public function __construct(CategoryManager $CategoryManager)
    {
        $this->CategoryManager = $CategoryManager;
    }

    public function requestStore($input)
    {
        try {
            $this->CategoryManager->storeNewCategory($input);
        } catch (CategoryAlreadyExistsException $e) {
            Session::flash('dvs-error-message', "The category {$input['name']} already exists!");
        }

        return Redirect::back();
    }

    public function requestDestroy($input)
    {
        $this->CategoryManager->destroyCategory($input);
        return Redirect::back();
    }

    public function requestRename($input)
    {
        $path = array_get($input, 'path');
        $newName = array_get($input, 'newname');
        $this->CategoryManager->renameCategory($path, $newName);
    }
}