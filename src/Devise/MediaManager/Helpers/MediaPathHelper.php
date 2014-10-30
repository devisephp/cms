<?php namespace Devise\MediaManager\Helpers;

use Devise\MediaManager\Exceptions\InvalidFileException;
use stdClass, Config, URL;

class MediaPathHelper
{
	/**
	 * Create a new Media Path Helper
	 * the purpose of this class is to determine
	 * paths for media (and versions of media)
	 */
	public function __construct($basepath = null, $baseurl = null, Config $Config)
	{
		$this->basepath = $basepath ?: public_path();
		$this->baseurl = URL::asset('/');
		$this->Config = Config::getFacadeRoot();
	}

	/**
	 * Gets the basepath for us
	 *
	 * @return string
	 */
	public function basePath()
	{
		return $this->basepath;
	}

	/**
	 * Check to see if a file exists or not
	 *
	 * @return boolean
	 */
	public function fileExists($mediapath)
	{
		return is_file($this->basepath . $mediapath);
	}

	/**
	 * Create an empty file in this location
	 *
	 */
	public function touch($mediapath)
	{
		$basepath = dirname($this->basepath . $mediapath);

		// create this directory if it doesn't exist
		if (!is_dir($basepath))
		{
			mkdir($basepath, 0755, true);
		}

		touch($this->basepath . $mediapath);
	}

	/**
	 * Gets the versioned path to this $url path
	 */
	public function fileVersionInfoFromUrl($url)
	{
		$obj = new stdClass;

		$obj->basepath = $this->basepath;
		$obj->mediapath = $this->basepath . '/media';
		$obj->mediaversionpath = $this->basepath . '/media-versions';

		$obj->md5 = md5($url);
		$obj->ext = pathinfo($url, PATHINFO_EXTENSION);
		$obj->partition = substr($obj->md5, 0, 3) . '/' . substr($obj->md5, 3, 3) . '/' . $obj->md5;

		$obj->tempfile = false;

		$obj->filepath = $this->basepath . '/' . $obj->md5;
		$obj->filename = $obj->md5;
		$obj->filedir = $this->basepath;

		$obj->versionpath = "{$this->basepath}/media-versions/{$obj->partition}/{$obj->filename}" . ($obj->ext ? ".{$obj->ext} " : '');
		$obj->versionname = pathinfo($obj->versionpath, PATHINFO_FILENAME);
		$obj->versiondir = "{$this->basepath}/media-versions/{$obj->partition}";

		return $obj;
	}

	/**
	 * Gets the versioned path to this file
	 */
	public function fileVersionInfo($filePath)
	{
		$tempfile = false;
		$path = $this->basepath . $filePath;

		// we don't want to try and download an image from our
		// own website because that will cause a session deadlock
		// in php and crash the server
		if (strpos($filePath, $this->baseurl) === 0)
		{
			$path = $this->basepath . str_replace($this->baseurl, '/', $filePath);
		}
		// if this is a url that is not on our own website
		// then we need to fetch that file temporarily so
		// we can create a version of that file
		else if ($this->isUrlPath($filePath))
		{
			$path = $this->downloadFromUrl($filePath);
			$tempfile = $path;
		}

		//
		// if we don't have a file for our path then complain
		//
		if (!is_file($path))
		{
			throw new InvalidFileException("This is not a valid file: " . $path);
		}

		$obj = new stdClass;

		$obj->basepath = $this->basepath;
		$obj->mediapath = $this->basepath . '/media';
		$obj->mediaversionpath = $this->basepath . '/media-versions';

		$obj->md5 = md5_file($path);
		$obj->ext = pathinfo($path, PATHINFO_EXTENSION);
		$obj->partition = substr($obj->md5, 0, 3) . '/' . substr($obj->md5, 3, 3) . '/' . $obj->md5;

		$obj->tempfile = $tempfile;

		$obj->filepath = $path;
		$obj->filename = pathinfo($path, PATHINFO_FILENAME);
		$obj->filedir = dirname($path);

		$obj->versionpath = "{$this->basepath}/media-versions/{$obj->partition}/{$obj->filename}.{$obj->ext}";
		$obj->versionname = pathinfo($obj->versionpath, PATHINFO_FILENAME);
		$obj->versiondir = "{$this->basepath}/media-versions/{$obj->partition}";

		return $obj;
	}

	/**
	 * Make this path relative to public directory
	 *
	 * @return string
	 */
	public function makeRelativePath($path)
	{
		return str_replace($this->basepath, '', $path);
	}

	/**
	 * Returns the zencoder url for this filename
	 *
	 * @return string
	 */
	public function zencoderUrl($filename)
	{
		if ($this->isUrlPath($filename))
		{
			return $filename;
		}

		return $this->Config->get('devise::zencoder.callback-url') . $filename;
	}

	/**
	 * Downloads the image so that we can re-use it
	 * later and crop it and resize it accordingly
	 *
	 * @param  string $url
	 * @return string
	 */
	public function downloadFromUrl($path)
	{
		$tmpFilePath = tempnam(sys_get_temp_dir(), 'dvs_downloaded_field');

		try {
			$ch = curl_init($path);
			$fp = fopen($tmpFilePath, 'wb');
			curl_setopt($ch, CURLOPT_FILE, $fp);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_exec($ch);
			curl_close($ch);
			fclose($fp);

			// add the extension to this temp file
			// and rename to a md5 string so it is unique
			// in case we download this file again
			$ext = image_type_to_extension(exif_imagetype($tmpFilePath));
			$md5 = md5_file($tmpFilePath);
			$newFilePath = sys_get_temp_dir() .'/' . $md5 . $ext;

			rename($tmpFilePath, $newFilePath);
			return $newFilePath;
		} catch (\Exception $e) {}

		return $path;
	}

	/**
	 * Returns true or false depending on if this is
	 * an image url or not
	 *
	 * @param  string $path
	 * @return boolean
	 */
	public function isUrlPath($url)
	{
		return strpos($url, 'https://') === 0 || strpos($url, 'http://') === 0 || strpos($url, 'ftp://') === 0;
	}
}