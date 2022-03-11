<?php

namespace Devise\Media\Files;

use Devise\Support\Framework;

class ImageAlts
{
    protected $Cache;

    protected $Config;

    protected $Storage;

    /**
     * Construct a new response handler
     *
     * @param Framework $Framework
     */
    public function __construct(Framework $Framework)
    {
        $this->Cache = $Framework->Cache;
        $this->Config = $Framework->Config;
        $this->Storage = $Framework->storage->disk(config('devise.media.disk'));
    }

    public function get($file)
    {
        return $this->fromName($file);
    }


    public function addToCache($filePath, $alt)
    {
        $all = $this->Cache->get('dvs.image-alts');

        $all[$filePath] = $alt;

        $this->Cache->forever('dvs.image-alts', $all);
    }

    public function cacheAll()
    {
        $path = $this->Config
            ->get('devise.media.image-alts-directory');

        $keyVal = [];

        if ($path) {
            $all = $this->Storage
                ->allFiles($path);

            foreach ($all as $altFile) {
                $alt = $this->Storage->get($altFile);
                $filePath = rtrim($altFile, '.txt');
                $filePath = str_replace('alts/', '/storage/media/', $filePath);
                $keyVal[$filePath] = $alt;
            }
        }

        $this->Cache
            ->forever('dvs.image-alts', $keyVal);
    }

    protected function fromName($file)
    {
        $parts = explode('.', $file);
        array_pop($parts);

        $withoutExtension = implode('', $parts);

        $parts = explode('/', $withoutExtension);
        $fileName = array_pop($parts);

        $caption = str_replace('-', ' ', $fileName);
        $caption = str_replace('_', ' ', $caption);

        return $caption;
    }
}