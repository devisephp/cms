<?php

namespace Devise\Media;

use Devise\Support\Framework;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;

use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\ServerFactory;
use League\Glide\Signatures\SignatureFactory;
use League\Glide\Urls\UrlBuilderFactory;

class Glide
{
    private $server;

    private $Config;

    private $Storage;

    private $Cache;

    private $SignatureFactory;

    private $UrlBuilderFactory;

    private $Str;

    protected static $imageURLs = null;

    /**
     * Glide constructor.
     */
    public function __construct(
        Framework $Framework,
        SignatureFactory $SignatureFactory,
        UrlBuilderFactory $UrlBuilderFactory,
        Str $Str
    ) {
        $this->server = ServerFactory::create(
            [
                'response' => new LaravelResponseFactory(app('request')),
                'source' => $Framework->disk->getDriver(),
                'source_path_prefix' => $Framework->config->get('devise.media.source-directory'),
                'cache' => $Framework->disk->getDriver(),
                'cache_path_prefix' => $Framework->config->get('devise.media.cached-images-directory'),
                'group_cache_in_folders' => $Framework->config->get('devise.media.group-cache-in-folders', false),
                'base_url' => '/styled/preview/',
                'driver' => $Framework->config->get('devise.media.driver')
            ]
        );

        $this->Config = $Framework->config;
        $this->Storage = $Framework->disk;
        $this->Cache = $Framework->cache;
        $this->SignatureFactory = $SignatureFactory;
        $this->UrlBuilderFactory = $UrlBuilderFactory;
        $this->Str = $Str;
    }

    public function getImageResponse($path)
    {
        try {
            $image = $this->server->getImageResponse($path, request()->all());

            if (request()->has('s') && !$this->getImageURL(request()->get('s'))) {
                $cachePath = $this->server->getCachePath($path, request()->all());
                $cacheUrl = $this->Storage->url($cachePath);

                $this->Storage->setVisibility($cachePath, 'public');

                $this->saveImageURL(request()->get('s'), $cacheUrl);
            }

            return $image;
        } catch (\Exception $e) {
            return Image::make(base_path('vendor/devisephp/cms/resources/images/file-icon.gif'))
                ->response();
        }
    }

    public function getFieldUrl($fieldPath)
    {
        $parts = parse_url($fieldPath);
        if (isset($parts['query'])) {
            parse_str($parts['query'], $input);

            return $this->getImageURL($input['s'], $fieldPath);
        }

        return $fieldPath;
    }

    protected function getImageURL($signature, $default = null)
    {
        $this->loadAllUrls();
        if (isset(self::$imageURLs[$signature])) {
            return self::$imageURLs[$signature];
        }

        return $default;
    }

    protected function saveImageURL($signature, $url)
    {
        DB::table('dvs_image_urls')
            ->insert(
                [
                    'signature' => $signature,
                    'url' => $url,
                ]
            );

        $this->reloadAllUrls();
    }

    protected function reloadAllUrls()
    {
        Cache::forget('dvs_image_urls');
        $this->loadAllUrls(true);
    }

    protected function loadAllUrls($force = false)
    {
        if (!self::$imageURLs || $force) {
            self::$imageURLs = Cache::rememberForever(
                'dvs_image_urls',
                function () {
                    return DB::table('dvs_image_urls')
                        ->pluck('url', 'signature')
                        ->toArray();
                }
            );
        }
    }

    public function validateSignature($path, $input)
    {
        $signKey = $this->getKey();

        $this->SignatureFactory
            ->create($signKey)
            ->validateRequest($path, $input);
    }

    public function generateSignedUrl($path, $params)
    {
        // setting visibility
        $pathForVisibility = str_replace('/storage/media', '', $path);
        $storagePath = '/media' . $pathForVisibility;

        if (!$this->Storage->exists($storagePath)) {
            $parts = explode('.', $pathForVisibility);
            $extension = $parts[count($parts) - 1];
            if (preg_match('/[A-Z]/', $extension)) {
                // extension has at least 1 upper case letter
                $pathForVisibility = str_replace(
                    '.' . $extension,
                    '.' . strtolower($extension),
                    $pathForVisibility
                );
                $storagePath = '/media' . $pathForVisibility;
                if (!$this->Storage->exists($storagePath)) {
                    abort(404, $storagePath . ' Not Found');
                }
            } else {
                abort(404, $storagePath . ' Not Found');
            }
        }

        $filePath = $this->server->makeImage($pathForVisibility, $params);
        $this->Storage->setVisibility($filePath, 'public');

        $signKey = $this->getKey();

        $fileName = pathinfo($path);


        if (!isset($fileName['dirname']) || !isset($fileName['basename'])) {
            abort(400, 'Unable to parse given image path ' . $path);
        }

        $urlBuilder = $this->UrlBuilderFactory
            ->create($fileName['dirname'] . '/', $signKey);

        $url = $urlBuilder->getUrl($fileName['basename'], $params);

        return '/storage/styled' . str_replace('/storage/media', '', $url);
    }

    private function getKey()
    {
        $key = $this->Config->get('devise.media.security.key');

        if ($this->Str->startsWith($key, 'base64:')) {
            return substr($key, 7);
        }

        return $key;
    }
}