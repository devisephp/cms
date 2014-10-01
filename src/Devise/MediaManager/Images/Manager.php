<?php namespace Devise\MediaManager\Images;

use Config;
use Illuminate\Filesystem\Filesystem;
use Devise\MediaManager\Helpers\CategoryPaths;
use Imagick;

class Manager
{
    protected $Filesystem;
    protected $CategoryPaths;

    public function __construct(Filesystem $Filesystem, CategoryPaths $CategoryPaths)
    {
        $this->Filesystem = $Filesystem;
        $this->CategoryPaths = $CategoryPaths;
    }

    public function extractImagesForCallback($input)
    {
        if(isset($input['images']) && count($input['images'])){
            $finalImages = array();
            $localPath = (isset($input['category'])) ? $this->CategoryPaths->fromDot($input['category']) : '';
            $browserPath = $this->CategoryPaths->browserPath($localPath);

            foreach ($input['images'] as $image) {
                $finalImages[] = $browserPath . $image;
            }

            return $finalImages;
        }
    }

    /*
        convert 
            -colorspace RGB +sigmoidal-contrast 6.5,50% 
            -filter Lanczos 
            -distort resize 1500x 
            -sigmoidal-contrast 6.5,50% 
            -colorspace sRGB 
            -strip 
            -interlace Plane 
            -quality 80
        reed.jpg 
        reed_sigmoidal_RGB.jpg
    */
    public function cropAndSaveFile($input)
    {
        if(isset($input['image'])){
            $croppedName = $this->getNewCroppedName($input['image'], $input['cropper']['width'], $input['cropper']['height']);
            $localPath = (isset($input['category'])) ? $this->CategoryPaths->fromDot($input['category']) : '';
            $serverPath = $this->CategoryPaths->serverPath($localPath);
            $imagePath = $serverPath . $input['image'];

            $image = new Imagick($imagePath);
            $pctChange = $image->getImageWidth() / 500;


            $image->cropImage($pctChange*$input['cropper']['w'], $pctChange*$input['cropper']['h'], $pctChange*$input['cropper']['x'], $pctChange*$input['cropper']['y']);
            
            // $image->setImageColorspace(Imagick::COLORSPACE_RGB);
            // $image->sigmoidalContrastImage(true, 6.5, .5);
            
            $image->resizeImage($input['cropper']['width'],$input['cropper']['height'],Imagick::FILTER_LANCZOS,1);
            
            // $image->sigmoidalContrastImage(true, 6.5, .5);
            // $image->setImageColorspace(Imagick::COLORSPACE_SRGB);
            // $image->stripImage();
            // $image->setImageInterlaceScheme(Imagick::INTERLACE_PLANE);
            $image->setImageCompressionQuality(80);

            $image->writeImage($serverPath . $croppedName);

            return $croppedName;
        } else {
            return false;
        }
    }

    private function getNewCroppedName($currentName, $width, $height)
    {
        $nameArr = explode('.', $currentName);
        $inject = Config::get('devise::media-manager.crop-key') . '.' . $width . 'x' . $height;
        array_splice($nameArr, count($nameArr) - 1, 0, $inject);
        return implode('.', $nameArr);
    }
}