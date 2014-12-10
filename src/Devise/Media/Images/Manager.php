<?php namespace Devise\Media\Images;

use Devise\Media\Files\Filesystem;
use Devise\Media\Categories\CategoryPaths;

/**
 * Class Manager takes care of image management. This lets us
 * get a list of images and also crop and resize images
 *
 * @package Devise\Media\Images
 */
class Manager
{
    /**
     * @var Filesystem
     */
    protected $Filesystem;

    /**
     * @var CategoryPaths
     */
    protected $CategoryPaths;

    /**
     * @var Images
     */
    protected $Images;

    /**
     * Construct a new image manager
     *
     * @param Filesystem $Filesystem
     * @param CategoryPaths $CategoryPaths
     * @param Images $Images
     * @param \Illuminate\Config\Repository $Config
     */
    public function __construct(Filesystem $Filesystem, CategoryPaths $CategoryPaths, Images $Images, $Config = null)
    {
        $this->Filesystem = $Filesystem;
        $this->CategoryPaths = $CategoryPaths;
        $this->Images = $Images;
        $this->Config = $Config ?: \Config::getFacadeRoot();
    }

    /**
     * Not sure what this is for. Looks like it extracts images
     * from a category path...
     *
     * @param $input
     * @return array
     */
    public function extractImagesForCallback($input)
    {
        $finalImages = array();

        if (isset($input['images']) && count($input['images']))
        {
            $localPath = (isset($input['category'])) ? $this->CategoryPaths->fromDot($input['category']) : '';
            $browserPath = $this->CategoryPaths->browserPath($localPath);

            foreach ($input['images'] as $image)
            {
                $finalImages[] = $browserPath . $image;
            }
        }

        return $finalImages;
    }

    /**
     * Image url for a given category and image
     *
     * @param $input
     * @return string
     */
    public function getImageUrl($input)
    {
        $localPath = (isset($input['category'])) ? $this->CategoryPaths->fromDot($input['category']) : '';
        $browserPath = $this->CategoryPaths->browserPath($localPath);
        return $browserPath . $input['image'];
    }

    /**
     * Crop and save an image
     *
     * @param $input
     * @return string
     */
    public function cropAndSaveFile($input)
    {
        $imagePath = array_get($input, 'image', null);

        if (is_null($imagePath))
        {
            return false;
        }

        // lots of variables to make this code easier to read
        $width = $input['cropper']['width'];
        $height = $input['cropper']['height'];
        $cropWidth = $input['cropper']['w'];
        $cropHeight = $input['cropper']['h'];
        $cropX = $input['cropper']['x'];
        $cropY = $input['cropper']['y'];

        // find the paths
        $croppedName = $this->getNewCroppedName($imagePath, $width, $height);
        $localPath = (isset($input['category'])) ? $this->CategoryPaths->fromDot($input['category']) : '';
        $serverPath = $this->CategoryPaths->serverPath($localPath);
        $imagePath = $serverPath . $input['image'];

        // resize and crop image and save it to media directory
        $image = $this->Images->cropAndResizeImage($imagePath, $width, $height, $cropWidth, $cropHeight, $cropX, $cropY);
        $this->Images->saveImage($image, $serverPath . $croppedName);

        return $croppedName;
    }

    /**
     * This cropped name is generated for us
     *
     * @param $currentName
     * @param $width
     * @param $height
     * @return string
     */
    private function getNewCroppedName($currentName, $width, $height)
    {
        $nameArr = explode('.', $currentName);
        $inject = $this->Config->get('devise::media-manager.crop-key') . '.' . $width . 'x' . $height;
        array_splice($nameArr, count($nameArr) - 1, 0, $inject);
        return implode('.', $nameArr);
    }
}