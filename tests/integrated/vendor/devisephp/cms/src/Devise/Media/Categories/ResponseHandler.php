<?php namespace Devise\Media\Categories;

/**
 * Class ResponseHandler handles the controller side
 * of managing categories. These methods are likely
 * referenced in dvs_pages table
 *
 * @package Devise\Media\Categories
 */
class ResponseHandler
{
    /**
     * @var CategoryManager
     */
    protected $CategoryManager;

    /**
     * Construct a new response handler for categories
     *
     * @param Manager $CategoryManager
     */
    public function __construct(Manager $CategoryManager, $Redirect = null)
    {
        $this->CategoryManager = $CategoryManager;
        $this->Redirect = $Redirect ?: \Redirect::getFacadeRoot();
    }

    /**
     * Request a category be stored
     *
     * @param $input
     * @return mixed
     */
    public function requestStore($input)
    {
        try {
            $this->CategoryManager->storeNewCategory($input);
        } catch (CategoryAlreadyExistsException $e) {
            \Session::flash('dvs-error-message', "The category {$input['name']} already exists!");
        }

        return $this->Redirect->back();
    }

    /**
     * Request a category be destroyed
     *
     * @param $input
     * @return mixed
     */
    public function requestDestroy($input)
    {
        $this->CategoryManager->destroyCategory($input);
        return $this->Redirect->back();
    }

    /**
     * Request a category be renamed
     *
     * @param $input
     */
    public function requestRename($input)
    {
        $path = array_get($input, 'path');
        $newName = array_get($input, 'newname');
        $this->CategoryManager->renameCategory($path, $newName);
    }
}