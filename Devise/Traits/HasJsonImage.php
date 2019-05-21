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
        if (isset($value->url) && $this->isUsingS3())
        {
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
                $user = Auth::user();
                if (!$user || !$user->hasPermission('manage slices'))
                {
                    $glide = App::make(Glide::class);

                    return $glide->getFieldUrl($path);
                }

                return $path;
            }

            return $storage->url(str_replace('/storage/', '', $path));
        }

        return $path;
    }

    private function updateImageAlt(&$value)
    {
        if (isset($value->type) && $value->type == 'image' && isset($value->media) && isset($value->media->original))
        {
            $imageAlts = App::make(ImageAlts::class);

            $value->alt = $imageAlts->get($value->media->original);
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