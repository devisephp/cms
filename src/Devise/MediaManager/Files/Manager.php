<?php namespace Devise\MediaManager\Files;

use Config;
use Illuminate\Filesystem\Filesystem;
use Devise\MediaManager\Helpers\CategoryPaths;
use Imagick;

class Manager
{
    protected $Filesystem;
    protected $CategoryPaths;

    public function __construct(Filesystem $Filesystem, CategoryPaths $CategoryPaths)
    {
        $this->Filesystem = $Filesystem;
        $this->CategoryPaths = $CategoryPaths;
        $this->basepath = public_path() . '/media/';
    }

    public function saveUploadedFile($input)
    {
        if($input['file']){
            $file = $input['file'];
            $localPath = (isset($input['category'])) ? $this->CategoryPaths->fromDot($input['category']) : '';
            $serverPath = $this->CategoryPaths->serverPath($localPath);

            $file->move($serverPath, $file->getClientOriginalName());

            if(strpos($file->getClientMimeType(), 'image') !== false){
                $newThumbName = $this->getNewThumbName($file->getClientOriginalName());
                $image = new Imagick($serverPath . $file->getClientOriginalName());
                $image->cropThumbnailImage(200,200);
                $image->setImageCompressionQuality(80);
                $image->writeImage($serverPath . $newThumbName);
            }

        } else {
            return false;
        }
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
        $basedir = dirname($this->basepath . $newpath);

        if (!is_dir($basedir))
        {
            mkdir($basedir, 0755, $recursive = true);
        }

        rename($this->basepath . $filepath, $this->basepath . $newpath);
    }

    /**
     * Remove uploaded files from the /media directory
     *
     * @param  string $filepath
     * @return void
     */
    public function removeUploadedFile($filepath)
    {
        unlink($this->basepath . $filepath);

        // remove the thumbnail if there is one
        $thumbnail = $this->basepath . dirname($filepath) . '/' . $this->getNewThumbName(basename($filepath));
        if (is_file($thumbnail))
        {
            unlink($thumbnail);
        }
    }

    private function getNewThumbName($currentName)
    {
        $nameArr = explode('.', $currentName);
        $inject = Config::get('devise::media-manager.thumb-key');
        array_splice($nameArr, count($nameArr) - 1, 0, $inject);
        return implode('.', $nameArr);
    }
}