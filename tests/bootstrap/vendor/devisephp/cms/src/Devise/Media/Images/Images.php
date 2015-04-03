<?php namespace Devise\Media\Images;

use Devise\Media\Files\InvalidFileException;
use Imagick;

class Images
{
    /**
     * Copies an image from one location to another location,
     * also handles creating sub directories if they don't already
     * exist for us
     *
     * @param string $fromImagePath
     * @param string $toImagePath
     * @throws InvalidFileException
     * @return string
     */
	public function copyImage($fromImagePath, $toImagePath)
	{
		if (!is_file($fromImagePath))
		{
			throw new InvalidFileException("This is not a valid image: " . $fromImagePath);
		}

		if (!is_dir(dirname($toImagePath)))
		{
			mkdir(dirname($toImagePath), 0755, true);
		}

		if (!file_exists($toImagePath))
		{
			copy($fromImagePath, $toImagePath);
		}

		return $toImagePath;
	}

    /**
     * Crop this image path to crop dimensions, these dimensions
     * are coming from the JCrop javascript tool being passed in
     * to us
     *
     * @param string|Imagick  $imagePath
     * @param integer         $cropWidth
     * @param integer         $cropHeight
     * @param integer         $cropX
     * @param integer         $cropY
     * @return Imagick
     */
	public function cropImage($imagePath, $cropWidth, $cropHeight, $cropX, $cropY)
	{
        $image = is_a($imagePath, 'Imagick') ? $imagePath : new Imagick($imagePath);

        // uses 500 here because that is the width on the front end jCropper tool
        $pctChange = $image->getImageWidth() / 500;

        // crop the image accordingly
        $image->cropImage($pctChange*$cropWidth, $pctChange*$cropHeight, $pctChange*$cropX, $pctChange*$cropY);

        return $image;
	}

    /**
     * Lets us know if we can make a thumbnail from this file objet
     *
     * @param  File $file
     * @return boolean
     */
    public function canMakeThumbnailFromFile($file)
    {
        return true;
    }

    /**
     * Resize this image path to specified width and height
     *
     * @param string|Imagick  $imagePath
     * @param integer         $width
     * @param integer         $height
     * @return Imagick
     */
	public function resizeImage($imagePath, $width, $height)
	{
        $image = is_a($imagePath, 'Imagick') ? $imagePath : new Imagick($imagePath);

        // $image->setImageColorspace(Imagick::COLORSPACE_RGB);
        // $image->sigmoidalContrastImage(true, 6.5, .5);

		// resize the image accordingly
        $image->resizeImage($width, $height, Imagick::FILTER_LANCZOS, 1);

        // $image->sigmoidalContrastImage(true, 6.5, .5);
        // $image->setImageColorspace(Imagick::COLORSPACE_SRGB);
        // $image->stripImage();
        // $image->setImageInterlaceScheme(Imagick::INTERLACE_PLANE);
        $image->setImageCompressionQuality(80);

        return $image;
	}

    /**
     * Crops the image path and then resizes, used by the JCrop tool
     * when we upload images via the Devise Sidebar
     *
     * @param string  $imagePath
     * @param integer $width
     * @param integer $height
     * @param integer $cropWidth
     * @param integer $cropHeight
     * @param integer $cropX
     * @param integer $cropY
     * @return Imagick
     */
    public function cropAndResizeImage($imagePath, $width, $height, $cropWidth, $cropHeight, $cropX, $cropY)
    {
        $image = is_a($imagePath, 'Imagick') ? $imagePath : new Imagick($imagePath);

        $image = $this->cropImage($image, $cropWidth, $cropHeight, $cropX, $cropY);

        $image = $this->resizeImage($image, $width, $height);

        return $image;
    }

    /**
     * Save the image to this path, also recursively
     * creates the directories if they don't exist
     *
     * @param Imagick $image
     * @param $path
     * @return mixed
     */
    public function saveImage(Imagick $image, $path)
    {
		if (!is_dir(dirname($path)))
		{
			mkdir(dirname($path), 0755, true);
		}

		if (!file_exists($path))
		{
	        $image->writeImage($path);
		}

        return $path;
    }

    /**
     * Makes a thumbnail out of a file
     *
     * @param $originalPath
     * @param string $newPath
     * @param string $mime
     * @return Imagick
     */
    public function makeThumbnailImage($originalPath, $newPath, $mime = 'image')
    {
        if (strpos($mime, 'image') === false)
        {
            return null;
        }

        $image = new Imagick($originalPath);
        $image->cropThumbnailImage(200,200);
        $image->setImageCompressionQuality(80);

        $this->saveImage($image, $newPath);

        return $image;
    }
}