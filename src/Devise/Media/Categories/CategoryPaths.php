<?php namespace Devise\Media\Categories;

/**
 * Class CategoryPaths converts dot paths to real paths
 * and also finds server paths and browser urls to the configured
 * root media directory where all our media files are stored at.
 *
 * @package Devise\Media\Categories
 */
class CategoryPaths
{
    /**
     * Create a new category path
     *
     * @param null $config
     */
    public function __construct($config = null)
    {
        $this->Config = $config ?: \Config::getFacadeRoot();
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
        return public_path() . '/' . $this->Config->get('devise::media-manager.root-dir') . '/' . $path;
    }

    /**
     * Browser path is the url path to this root media directory
     *
     * @param $path
     * @return string
     */
    public function browserPath($path)
    {
        $path = ($path != '') ? $path . '/' : '';
        return '/' . $this->Config->get('devise::media-manager.root-dir') . '/' . $path;
    }
}