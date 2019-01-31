<?php

namespace Devise\Http\Resources\Vue;

use Devise\Support\Framework;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\Route;

class FieldResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        $value = $this->value;

        if ($value)
        {
            if (is_object($value))
            {
                $value->id = $this->id;
            }

            if (isset($value->type) && $value->type == 'link')
            {
                if (isset($value->routeName)
                    && ($value->type == 'link')
                    && Route::has($value->routeName))
                {
                    $value->href = route($value->routeName);
                } else if (!isset($value->href))
                {
                    $value->href = $value->url;
                }
            }

            if (isset($value->type) && isset($value->url) && ($value->type == 'image' || $value->type == 'file'))
            {
                $storage = Framework::storage();

                if ($this->isMediaRelativePath($value->url))
                {
                    $url = $storage->url(trim($value->url, '/'));
                    if ($url)
                    {
                        $value->url = $url;
                    }
                }
            }
        }

        return $value;
    }

    public function isMediaRelativePath($path)
    {
        $folder = config('devise.media.source-directory');

        return (strpos($path, $folder) === 0 || strpos($path, $folder) === 1);
    }
}