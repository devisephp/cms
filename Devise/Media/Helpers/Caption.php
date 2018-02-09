<?php namespace Devise\Media\Helpers;

use Devise\Media\Paths;
use Devise\Support\Framework;

class Caption {

    /**
     * Construct a new Caption Helper
     *
     * @param  Paths $Paths
     * @param  Framework $Framework
     * @return void
     */
    public function __construct(Paths $Paths, Framework $Framework)
    {
        $this->Paths = $Paths;
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
        $cptPath = $this->Paths->imageCaptionPath($imagePath);

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
        $cptPath = $this->Paths->imageCaptionPath($imagePath);

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
        $captionPath = $this->Paths->imageCaptionPath($imagePath);
        
        return $this->File->put($captionPath, $text);
    }

}