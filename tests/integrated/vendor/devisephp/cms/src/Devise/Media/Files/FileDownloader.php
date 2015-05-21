<?php namespace Devise\Media\Files;

/**
 * Class FileDownloader downloads a file from
 * the internet and saves it into a specified directory
 *
 * @package Devise\Media\Files
 */
class FileDownloader
{
	/**
	 * Create a new FileDownloader
	 *
	 */
	public function __construct()
	{

	}

	/**
	 * Download a file from the given $url and save
	 * it to $toPath with $filename. If $filename
	 * is null then we just use the name from the $url
	 *
	 * @param  string $url
	 * @param  string $toPath
	 * @param  string $filename
	 * @return string
	 */
	public function download($url, $toPath, $filename)
	{
		$basepath = dirname($toPath . '/' . $filename);
		$basename = basename($filename);

		// create this directory if it doesn't exist
		if (!is_dir($basepath))
		{
			mkdir($basepath, 0755, true);
		}

		// use curl to download
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($ch);
		curl_close($ch);

		// save the $data into this file
		return file_put_contents($basepath . '/' . $basename, $data);
	}
}