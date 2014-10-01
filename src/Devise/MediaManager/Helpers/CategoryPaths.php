<?php namespace Devise\MediaManager\Helpers;

use Config;

class CategoryPaths
{
    public function fromDot($path)
    {
        return implode('/', explode('.', $path));
    }
    public function toDot($path)
    {
        return implode('.', explode('/', $path));
    }
    public function serverPath($path)
    {
        $path = ($path != '') ? $path . '/' : '';
        return public_path() . '/' . Config::get('devise::media-manager.root-dir') . '/' . $path;
    }
    public function browserPath($path)
    {
        $path = ($path != '') ? $path . '/' : '';
        return '/' . Config::get('devise::media-manager.root-dir') . '/' . $path;
    }
}