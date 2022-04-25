<?php namespace Devise\Media\Files;

use Devise\Media\Directories\DirectoryPaths;
use Devise\Sites\SiteDetector;
use Devise\Support\Framework;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * Class Manager
 * @package Devise\Media\Files
 */
class Manager
{
    private $CategoryPaths;

    private $SiteDetector;

    protected $Storage;

    /**
     * @param DirectoryPaths $CategoryPaths
     * @param SiteDetector $SiteDetector
     */
    public function __construct(DirectoryPaths $CategoryPaths, SiteDetector $SiteDetector, Framework $Framework)
    {
        $this->CategoryPaths = $CategoryPaths;
        $this->SiteDetector = $SiteDetector;

        $this->Storage = $Framework->storage->disk(config('devise.media.disk'));
    }

    /**
     *
     */
    public function saveUploadedFile($file, $dir)
    {
        $originalName = $file->getClientOriginalName();
        $name = Str::slug(pathinfo($originalName, PATHINFO_FILENAME));
        $ext = pathinfo($originalName, PATHINFO_EXTENSION);

        $this->Storage->putFileAs($dir, $file, $name . '.' . $ext, ['visibility' => 'public']);
    }

    /**
     *
     */
    public function removeUploadedFile($mediaRoute)
    {
        $this->Storage->delete($mediaRoute);
    }

}
