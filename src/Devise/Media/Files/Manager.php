<?php namespace Devise\Media\Files;

use Devise\Media\Categories\CategoryPaths;
use Devise\Media\Images\Images;

/**
 * Class Manager
 * @package Devise\Media\Files
 */
class Manager
{
    /**
     * @var Filesystem
     */
    protected $Filesystem;

    /**
     * @var CategoryPaths
     */
    protected $CategoryPaths;

    /**
     * @var Image
     */
    protected $Image;

    /**
     * Construct a new File manager
     *
     * @param Filesystem $Filesystem
     * @param CategoryPaths $CategoryPaths
     * @param Image $Image
     */
    public function __construct(Filesystem $Filesystem, CategoryPaths $CategoryPaths, Images $Image, $Config = null)
    {
        $this->Filesystem = $Filesystem;
        $this->CategoryPaths = $CategoryPaths;
        $this->Image = $Image;
        $this->basepath = public_path() . '/media/';
        $this->Config = $Config ?: \Config::getFacadeRoot();
    }

    /**
     * Saves the uploaded file to the media directory
     *
     * @param $input
     * @return bool
     */
    public function saveUploadedFile($input)
    {
        $file = array_get($input, 'file', null);

        if (is_null($file))
        {
            return false;
        }

        $originalName = $file->getClientOriginalName();
        $localPath = (isset($input['category'])) ? $this->CategoryPaths->fromDot($input['category']) : '';
        $serverPath = $this->CategoryPaths->serverPath($localPath);

        $file->move($serverPath, $originalName);

        $this->Image->makeThumbnailImage($serverPath . $originalName, $serverPath . $this->getNewThumbName($originalName), $file->getClientMimeType());
    }

    /**
     * Renames an uploaded file
     *
     * @param  string $filepath
     * @param  string $newpath
     * @return void
     */
    public function renameUploadedFile($filepath, $newpath)
    {
        return $this->Filesystem->rename($this->basepath . $filepath, $this->basepath . $newpath);
    }

    /**
     * Remove uploaded files from the /media directory
     *
     * @param  string $filepath
     * @return void
     */
    public function removeUploadedFile($filepath)
    {
        $this->Filesystem->delete($this->basepath . $filepath);

        // remove the thumbnail if there is one
        $thumbnail = $this->basepath . dirname($filepath) . '/' . $this->getNewThumbName(basename($filepath));

        if (is_file($thumbnail))
        {
            $this->Filesystem->delete($thumbnail);
        }
    }

    /**
     * Change this
     * @param $currentName
     * @return string
     */
    private function getNewThumbName($currentName)
    {
        $nameArr = explode('.', $currentName);
        $inject = $this->Config->get('devise.media-manager.thumb-key');
        array_splice($nameArr, count($nameArr) - 1, 0, $inject);
        return implode('.', $nameArr);
    }
}