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
    public function saveUploadedFile($input)
    {
        $categoryPath = (isset($input['directory'])) ? $this->CategoryPaths->fromDot($input['directory']) : '';
        $file = Arr::get($input, 'file', null);

        $serverPath = $this->CategoryPaths->serverPath($categoryPath);

        $originalName = $file->getClientOriginalName();
        $name = Str::slug(pathinfo($originalName, PATHINFO_FILENAME));
        $ext = pathinfo($originalName, PATHINFO_EXTENSION);

        $this->Storage->putFileAs($serverPath, $file, $name . '.' . $ext, ['visibility' => 'public']);
    }

    /**
     *
     */
    public function removeUploadedFile($mediaRoute)
    {
        $this->Storage->delete($mediaRoute);
    }

}
