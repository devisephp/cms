<?php namespace Devise\MediaManager\Files;

use Devise\MediaManager\Files\Manager as FileManager;
use Redirect;

class ResponseHandler
{
    protected $FileManager;

    public function __construct(FileManager $FileManager)
    {
        $this->FileManager = $FileManager;
    }

    public function requestUpload($input)
    {
        if ($this->FileManager->saveUploadedFile($input))
        {
            return Redirect::back();
        }

        return Redirect::back();
    }

    public function requestRename($input)
    {
        $filepath = array_get($input, 'filepath', '');
        $newpath = array_get($input, 'newpath', '');

        return $this->FileManager->renameUploadedFile($filepath, $newpath);
    }

    public function requestRemove($input)
    {
        return $this->FileManager->removeUploadedFile(array_get($input, 'filepath', ''));
    }
}