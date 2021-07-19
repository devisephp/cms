<?php namespace Devise\Media\Directories;

use Devise\Sites\SiteDetector;
use Devise\Support\Framework;

/**
 * Class CategoryPaths converts dot paths to real paths
 * and also finds server paths and browser urls to the configured
 * root media directory where all our media files are stored at.
 *
 * @package Devise\Media\Directories
 */
class DirectoryPaths
{
    /**
     * Create a new category path
     *
     * @param Framework $Framework
     */
    public function __construct(SiteDetector $SiteDetector, Framework $Framework)
    {
        $this->SiteDetector = $SiteDetector;
        $this->Config = $Framework->Config;
    }

    /**
     * Convert dots to slashes in the path
     *
     * @param string $path
     * @return string
     */
    public function fromDot($path)
    {
        return implode('/', explode('.', $path));
    }

    /**
     * Convert slashes into dots in the path
     *
     * @param string $path
     * @return string
     */
    public function toDot($path)
    {
        return implode('.', explode('/', $path));
    }

    /**
     * Server path is the real path to the root media directory
     *
     * @param $path
     * @return string
     */
    public function serverPath($path)
    {
        $path = ($path != '') ? $path . '/' : '';

        return $this->basePath() . '/' . $path;
    }

    public function basePath()
    {
        return $this->Config->get('devise.media.source-directory');
    }
}