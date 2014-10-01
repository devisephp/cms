<?php namespace Devise\MediaManager\Files;

use Symfony\Component\Finder\Finder;

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
}