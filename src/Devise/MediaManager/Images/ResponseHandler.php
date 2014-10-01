<?php namespace Devise\MediaManager\Images;

use Devise\MediaManager\Images\Manager as ImageManager;
use Redirect;
use Request;
use URL;

class ResponseHandler
{
    protected $ImageManager;

    public function __construct(ImageManager $ImageManager)
    {
        $this->ImageManager = $ImageManager;
    }

    public function requestCrop($input)
    {
        if($newImage = $this->ImageManager->cropAndSaveFile($input))
        {
            $keepers = array_except($input, array('_token', 'cropper'));
            $keepers['images'][] = $newImage;

            return Redirect::to(URL::route('dvs-media-manager') . '?' . http_build_query($keepers));

        } else {
            
            return Redirect::back();

        }
    }
}