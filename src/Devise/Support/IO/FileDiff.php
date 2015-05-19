<?php namespace Devise\Support\IO;

use File;

class FileDiff
{
	public function __construct(File $File = null)
	{
		// $this->io = $io;
		$this->File = $File ?: File::getFacadeRoot();
	}

	/**
	 * Gets the files that exist in both $target and
	 * $source and have different md5sums
	 *
	 * @param  [type] $target
	 * @param  [type] $source
	 * @return [type]
	 */
	public function different($target, $source)
	{
		$different = [];
		$targetSums = $this->md5($target);
		$sourceSums = $this->md5($source);

		foreach ($targetSums as $targetFile => $targetSum)
		{
			if (array_key_exists($targetFile, $sourceSums) && $targetSums[$targetFile] != $sourceSums[$targetFile])
			{
				$different[] = $targetFile;
			}
		}

		return $different;
	}

	/**
	 * [unmodified description]
	 * @param  [type] $target
	 * @param  [type] $source
	 * @return [type]
	 */
	public function unmodified($target, $source)
	{
		$unmodified = [];
		$targetSums = $this->md5($target);
		$sourceSums = $this->md5($source);

		foreach ($targetSums as $targetFile => $targetSum)
		{
			if (!array_key_exists($targetFile, $sourceSums) || $targetSums[$targetFile] == $sourceSums[$targetFile])
			{
				$unmodified[] = $targetFile;
			}
		}

		return $unmodified;
	}

	/**
	 * [md5 description]
	 * @param  [type] $dir
	 * @return [type]
	 */
	public function md5($dir)
	{
		$sums = [];

		$allFiles = $this->File->allFiles($dir);

		foreach ($allFiles as $file)
		{
			$sums[$file->getRelativePathname()] = md5_file($file);
		}

		return $sums;
	}
}