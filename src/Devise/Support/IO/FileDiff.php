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
	 * @param  string $target
	 * @param  string $source
	 * @return array
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
	 * Returns all $target files that have not been overriden
	 * inside of $source directory
	 *
	 * @param  string $target
	 * @param  string $source
	 * @return array
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
	 * Gets the files that are inside of $target but
	 * missing from $source directory
	 *
	 * @param  string $target
	 * @param  string $source
	 * @return array
	 */
	public function missing($target, $source)
	{
		$missing = [];
		$targetSums = $this->md5($target);
		$sourceSums = $this->md5($source);

		foreach ($targetSums as $targetFile => $targetSum)
		{
			if (!array_key_exists($targetFile, $sourceSums) || $targetSums[$targetFile] == $sourceSums[$targetFile])
			{
				$missing[] = $targetFile;
			}
		}

		return $missing;
	}

	/**
	 * [md5 description]
	 * @param  [type] $dir
	 * @return [type]
	 */
	protected function md5($dir)
	{
		$sums = [];

		if (!$this->File->isDirectory($dir)) return [];

		$allFiles = $this->File->allFiles($dir);

		foreach ($allFiles as $file)
		{
			$sums[$file->getRelativePathname()] = md5_file($file);
		}

		return $sums;
	}
}