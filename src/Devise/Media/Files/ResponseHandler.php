<?php namespace Devise\Media\Files;

/**
 * Class ResponseHandler handles controller part of media manager
 * as far as uploading, renaming and removing media files goes
 *
 * @package Devise\Media\Files
 */
class ResponseHandler
{
    /**
     * @var Manager
     */
    protected $FileManager;

    /**
     * Construct a new response handler
     *
     * @param Manager $FileManager
     * @param null $Redirect
     */
    public function __construct(Manager $FileManager, $Redirect = null)
    {
        $this->FileManager = $FileManager;
        $this->Redirect = $Redirect ?: \Redirect::getFacadeRoot();
    }

    /**
     * Requests a file upload
     *
     * @param $input
     * @return mixed
     */
    public function requestUpload($input)
    {
        $this->FileManager->saveUploadedFile($input);

        return $this->Redirect->back();
    }

    /**
     * Requests a file rename
     *
     * @param $input
     */
    public function requestRename($input)
    {
        $filepath = array_get($input, 'filepath', '');
        $newpath = array_get($input, 'newpath', '');

        return $this->FileManager->renameUploadedFile($filepath, $newpath);
    }

    /**
     * Requests a file removal
     *
     * @param $input
     */
    public function requestRemove($input)
    {
        return $this->FileManager->removeUploadedFile(array_get($input, 'filepath', ''));
    }
}