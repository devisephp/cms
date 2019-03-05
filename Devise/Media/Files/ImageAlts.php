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
        if (!$this->Cache->has('dvs.image-alts')) $this->cacheAll();

        $all = $this->Cache
            ->get('dvs.image-alts');

        return $all[$file] ?? '';
    }

    public function cacheAll()
    {
        $path = $this->Config
            ->get('devise.media.image-alts-directory');

        $all = $this->Storage
            ->allFiles($path);

        $keyVal = [];

        foreach ($all as $altFile)
        {
            $alt = $this->Storage->get($altFile);
            $filePath = rtrim($altFile, '.txt');
            $filePath = str_replace('alts/', '/storage/media/', $filePath);
            $keyVal[$filePath] = $alt;
        }

        $this->Cache
            ->forever('dvs.image-alts', $keyVal);
    }
}