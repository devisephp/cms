<?php namespace Devise\Media\Helpers;

use File;
use Devise\Media\MediaPaths;
use Devise\Support\Framework;

class Caption {

    /**
     * Construct a new Caption Helper
     *
     * @param  MediaPaths $MediaPaths
     * @param  Framework $Framework
     * @return void
     */
    public function __construct(MediaPaths $MediaPaths, Framework $Framework)
    {
        $this->MediaPaths = $MediaPaths;
        $this->File = $Framework->file;
    }

    /**
     * Checks if a caption file exitst for the image passed
     *
     * @param  string $imagePath
     * @return boolean
     */
    public function exists($imagePath)
    {
        $cptPath = $this->MediaPaths->imageCaptionPath($imagePath);

        return $this->File->exists( $cptPath );
    }

    /**
     * Finds the caption text for an image
     *
     * @param  string $imagePath
     * @return string
     */
    public function text($imagePath)
    {
        $cptPath = $this->MediaPaths->imageCaptionPath($imagePath);

        if($this->File->exists( $cptPath )){
            return $this->File->get( $cptPath );
        }

        return null;
    }

    /**
     * Saves the text file using the image path, and text passed
     *
     * @param  string $imagePath
     * @return string $text
     */
    public function saveForImage($imagePath, $text)
    {
        $captionPath = $this->MediaPaths->imageCaptionPath($imagePath);
        
        return $this->File->put($captionPath, $text);
    }

}