<?php namespace Devise\Media\Images;

/**
 * Class ResponseHandler handles requests (controller/route)
 * made to crop images
 *
 * @package Devise\Media\Images
 */
class ResponseHandler
{
    /**
     * @var Manager
     */
    protected $ImageManager;

    /**
     * Construct a new image response handler
     *
     * @param Manager $ImageManager
     * @param null $Redirect
     * @param null $URL
     */
    public function __construct(Manager $ImageManager, $Redirect = null, $URL = null)
    {
        $this->ImageManager = $ImageManager;
        $this->Redirect = $Redirect ?: \Redirect::getFacadeRoot();
        $this->URL = $URL ?: \URL::getFacadeRoot();
    }

    /**
     * Request a crop
     *
     * @param $input
     * @return mixed
     */
    public function requestCrop($input)
    {
        if ($newImage = $this->ImageManager->cropAndSaveFile($input))
        {
            $keepers = array_except($input, array('_token', 'cropper'));
            $keepers['images'][] = $newImage;

            return $this->Redirect->to($this->URL->route('dvs-media-manager') . '?' . http_build_query($keepers));
        }

        return $this->Redirect->back();
    }
}