<?php namespace Devise\Media\Files;

use Symfony\Component\Finder\Finder;

/**
 * Class Filesystem inherits from Illuminate\Filesystem\Filesystem
 * but adds some additional functionality such as file searching.
 *
 * @package Devise\Media\Files
 */
class Filesystem extends \Illuminate\Filesystem\Filesystem
{
	/**
	 * Search this directory for this pattern
	 *
	 * @param  string $directory
	 * @param  string $pattern
	 * @return File[]
	 */
	public function search($directory, $pattern)
	{
		$finder = new Finder;

		$finder->files()->in("{$directory}")->name("*{$pattern}*");

		return $finder;
	}

    /**
     * Relocates a path from a location to a new location
     *
     * @param string $path
     * @param string $target
     */
    public function rename($path, $target)
    {
        $basedir = dirname($target);

        if (!is_dir($basedir))
        {
            mkdir($basedir, 0755, $recursive = true);
        }

        $this->move($path, $target);
    }
}