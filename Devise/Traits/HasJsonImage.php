<?php

namespace Devise\Traits;

use Devise\Media\Files\ImageAlts;
use Devise\Media\Glide;
use Devise\Support\Framework;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

trait HasJsonImage
{
    private function updateImageUrlsToStorage(&$value)
    {
        $user = Auth::user();
        if ($this->isUsingS3() && (!Auth::check() || !$user->hasPermission('manage slices')))
        {
            // only public users or loggin in users that can't manage the admin
            if (isset($value->url))
                $value->url = $this->convertToStoragePath($value->url);

            if (isset($value->media) && $value->media)
            {
                foreach ($value->media as $name => $path)
                {
                    $value->media->$name = $this->convertToStoragePath($path);
                }
            }
        }
    }

    private function convertToStoragePath($path)
    {
        if ($this->isMediaRelativePath($path))
        {
            $storage = Framework::storage();

            if (strpos($path, '/storage/styled/') !== false && strpos($path, 's=') !== false)
            {
                $glide = App::make(Glide::class);

                return $glide->getFieldUrl($path);
            }

            return $storage->url(str_replace('/storage/', '', $path));
        }

        return $path;
    }

    private function updateImageAlt(&$value)
    {
        if (isset($value->type) && $value->type == 'image')
        {
            $value->caption = "";

            if (isset($value->media) && isset($value->media->defaultImage))
            {
                $imageAlts = App::make(ImageAlts::class);

                $value->caption = $imageAlts->get($value->media->defaultImage);
            }
        }
    }

    private function isMediaRelativePath($path)
    {
        $folder = '/storage/';

        return (strpos($path, $folder) === 0 || strpos($path, $folder) === 1);
    }

    private function isUsingS3()
    {
        return (config('filesystems.disks.' . config('devise.media.disk') . '.driver') === 's3');
    }
}