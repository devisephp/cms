<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\Media\SaveMediaAlt;
use Devise\Media\Files\ImageAlts;
use Devise\Support\Framework;

use Illuminate\Routing\Controller;

/**
 *
 */
class MediaAltsController extends Controller
{
    protected $ImageAlts;

    protected $Config;

    protected $Storage;

    /**
     * Construct a new response handler
     *
     * @param Framework $Framework
     */
    public function __construct(ImageAlts $ImageAlts, Framework $Framework)
    {
        $this->ImageAlts = $ImageAlts;

        $this->Config = $Framework->Config;
        $this->Storage = $Framework->storage->disk(config('devise.media.disk'));
    }

    /**
     *
     * @param SaveMediaAlt $request
     */
    public function store(SaveMediaAlt $request)
    {
        $image = str_replace("storage/", '', $request->get('image'));

        if (!$this->Storage->exists($image)) abort(404);

        $path = '/' . $this->Config->get('devise.media.image-alts-directory') . substr($image, 6);

        $altFile = $path . '.txt';

        $this->Storage
            ->put($altFile, $request->get('alt_text'));

        $this->ImageAlts
            ->addToCache($request->get('image'), $request->get('alt_text'));
    }
}