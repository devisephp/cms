<?php namespace Devise\Media\Files;

use Devise\Media\Categories\CategoryPaths;
use Devise\Sites\SiteDetector;
use Devise\Support\Framework;

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
     * @param CategoryPaths $CategoryPaths
     * @param SiteDetector $SiteDetector
     */
    public function __construct(CategoryPaths $CategoryPaths, SiteDetector $SiteDetector, Framework $Framework)
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
        $file = array_get($input, 'file', null);

        $serverPath = $this->CategoryPaths->serverPath($categoryPath);

        $this->Storage->putFileAs($serverPath, $file, $file->getClientOriginalName());
    }

    /**
     *
     */
    public function removeUploadedFile($input)
    {
        $categoryPath = (isset($input['directory'])) ? $this->CategoryPaths->fromDot($input['directory']) : '';
        $file = array_get($input, 'file');

        $serverPath = $this->CategoryPaths->serverPath($categoryPath);
        $filePath = $serverPath . '/' . $file;

        $this->Storage->delete($filePath);
    }

}
