<?php namespace Devise\Fields\Events;

use Devise\Images\Images;
use Devise\Images\InvalidImageException;
use Devise\MediaManager\Helpers\MediaPathHelper;

class ImageFieldUpdated
{
	use \Devise\MessageBus;

	public function __construct(Images $Images, MediaPathHelper $MediaPathHelper)
	{
		$this->MediaPathHelper = $MediaPathHelper;
		$this->Images = $Images;
		$this->basepath = $this->MediaPathHelper->basePath();
	}

	/**
	 * This is called anytime after we update an image field
	 * in devise
	 *
	 * @param  Field       $field
	 * @param  FieldVersin $version
	 * @param  array       $input
	 * @return array
	 */
	public function handle($field, $version, $input)
	{
		$version->values->merge([
			'has_thumbnail' => array_get($input, 'has_thumbnail', false),
			'image_url' => $this->createVersionOfImage($version, $input),
			'thumbnail_url' => $this->createThumbnailOfImage($version, $input),
		]);

		$version->value = $version->values->toJSON();

		$version->save();
	}

	/**
	 * Create a version of this image, crops too when
	 * $crop is set to true
	 *
	 * @param FieldVersion $version
	 * @param boolean      $crop
	 * @return string
	 */
	protected function createVersionOfImage($version, $input)
	{
		if (!$version->values->image)
		{
			return '';
		}

		return array_get($input, '_crop_image', false)
			? $this->croppedImagePath($version)
			: $this->versionedImagePath($version);
	}

	/**
	 * Create a version of this thumbnail, crops too when
	 * $crop is set to true
	 *
	 * @param FieldVersion $version
	 * @param boolean      $crop
	 * @return string
	 */
	protected function createThumbnailOfImage($version, $input)
	{
		if (!array_get($input, 'has_thumbnail', false) || !$version->values->image)
		{
			return '';
		}

		return array_get($input, '_crop_thumbnail', false)
			? $this->croppedImagePath($version, 'thumbnail')
			: $this->resizedImagePath($version, 200, 200);
	}

	/**
	 * Create a version of this thumbnail, crops too when
	 * $crop is set to true
	 *
	 * @param FieldVersion $version
	 * @param boolean      $crop
	 * @return string
	 */
	protected function resizedImagePath($version, $width, $height)
	{
		// get the parts for this file string
		$info = $this->MediaPathHelper->fileVersionInfo($version->values->image);

		// create resizedImagePath
		$resizedImagePath = "{$info->versiondir}/{$info->filename}_{$width}_{$height}.{$info->ext}";

		// resize the versioned image
		$image = $this->Images->resizeImage($info->filepath, $width, $height);

		// save this resized image
		$this->Images->saveImage($image, $resizedImagePath);

		// remove temporary image file if there is one
		if ($info->tempfile) unlink($info->tempfile);

        // finally return this image path as a string so we can store it
        return $this->MediaPathHelper->makeRelativePath($resizedImagePath);
	}

	/**
	 * Creates a versioned copy of this image
	 *
	 * @param FieldVersion $version
	 * @return string
	 */
	protected function versionedImagePath($version)
	{
		if ($this->MediaPathHelper->isUrlPath($version->values->image))
		{
			return $version->values->image;
		}

		$info = $this->MediaPathHelper->fileVersionInfo($version->values->image);

		if ($info->tempfile) unlink($info->tempfile);

		return $this->MediaPathHelper->makeRelativePath($info->filepath);
	}

	/**
	 * Creates a cropped versioned copy of this image
	 *
	 * @param string       $fromImagePath
	 * @param FieldVersion $version
	 * @return string
	 */
	protected function croppedImagePath($version, $type = 'image')
	{
		// gather info about this file and where it should be versioned
		$info = $this->MediaPathHelper->fileVersionInfo($version->values->image);

		// setting variables so we can easily access them later
		$width = $version->values->{$type . '_width'};
		$height = $version->values->{$type . '_height'};
		$cropWidth = $version->values->{$type . '_crop_w'};
		$cropHeight = $version->values->{$type . '_crop_h'};
		$cropX = $version->values->{$type . '_crop_x'};
		$cropY = $version->values->{$type . '_crop_y'};

		// this is the croppedImagePath
		$croppedImagePath = "{$info->versiondir}/{$info->filename}_{$width}_{$height}_{$cropX}_{$cropY}.{$info->ext}";

		// crop and resize the versioned image
		$image = $this->Images->cropAndResizeImage($info->filepath, $width, $height, $cropWidth, $cropHeight, $cropX, $cropY);

		// save this cropped image
		$this->Images->saveImage($image, $croppedImagePath);

		// remove temporary image file if there is one
		if ($info->tempfile) unlink($info->tempfile);

        // finally return this image path as a string so we can store it
        return $this->MediaPathHelper->makeRelativePath($croppedImagePath);
	}
}