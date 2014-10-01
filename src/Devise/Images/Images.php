<?php namespace Devise\Images;

use Imagick;

class Images
{
	public function copyImage($fromImagePath, $toImagePath)
	{
		if (!is_file($fromImagePath))
		{
			throw new InvalidImageException("This is not a valid image: " . $fromImagePath);
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

	public function cropImage($imagePath, $cropWidth, $cropHeight, $cropX, $cropY)
	{
        $image = is_a($imagePath, 'Imagick') ? $imagePath : new Imagick($imagePath);

        // uses 500 here because that is the width on the front end jCropper tool
        $pctChange = $image->getImageWidth() / 500;

        // crop the image accordingly
        $image->cropImage($pctChange*$cropWidth, $pctChange*$cropHeight, $pctChange*$cropX, $pctChange*$cropY);

        return $image;
	}

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

    public function cropAndResizeImage($imagePath, $width, $height, $cropWidth, $cropHeight, $cropX, $cropY)
    {
        $image = is_a($imagePath, 'Imagick') ? $imagePath : new Imagick($imagePath);

        $image = $this->cropImage($image, $cropWidth, $cropHeight, $cropX, $cropY);

        $image = $this->resizeImage($image, $width, $height);

        return $image;
    }

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
}