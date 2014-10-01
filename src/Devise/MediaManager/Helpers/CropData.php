<?php namespace Devise\MediaManager\Helpers;

use Request;
use View;

class CropData
{
    protected $CategoryPaths;
    public function __construct(CategoryPaths $CategoryPaths)
    {
        $this->CategoryPaths = $CategoryPaths;
    }
    public function getImageUrl($input)
    {
        $localPath = (isset($input['category'])) ? $this->CategoryPaths->fromDot($input['category']) : '';
        $browserPath = $this->CategoryPaths->browserPath($localPath);
        return $browserPath . $input['image'];
    }
}