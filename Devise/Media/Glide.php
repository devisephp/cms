<?php

namespace Devise\Media;

use Devise\Support\Framework;

use Illuminate\Support\Str;

use Intervention\Image\Facades\Image;

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

    /**
     * Glide constructor.
     */
    public function __construct(Framework $Framework, SignatureFactory $SignatureFactory, UrlBuilderFactory $UrlBuilderFactory, Str $Str)
    {
        $this->server = ServerFactory::create([
            'response'               => new LaravelResponseFactory(app('request')),
            'source'                 => $Framework->disk->getDriver(),
            'source_path_prefix'     => $Framework->config->get('devise.media.source-directory'),
            'cache'                  => $Framework->disk->getDriver(),
            'cache_path_prefix'      => $Framework->config->get('devise.media.cached-images-directory'),
            'group_cache_in_folders' => false,
            'base_url'               => '/styled/preview/',
            'driver'                 => $Framework->config->get('devise.media.driver')
        ]);

        $this->Config = $Framework->config;
        $this->Storage = $Framework->disk;
        $this->Cache = $Framework->cache;
        $this->SignatureFactory = $SignatureFactory;
        $this->UrlBuilderFactory = $UrlBuilderFactory;
        $this->Str = $Str;
    }

    public function getImageResponse($path)
    {
        try
        {
            $image = $this->server->getImageResponse($path, request()->all());

            if (request()->has('s') && !$this->Cache->has('dvs.image.styled.' . request()->get('s')))
            {
                $cachePath = $this->server->getCachePath($path, request()->all());
                $cacheUrl = $this->Storage->url($cachePath);

                $this->Storage->setVisibility($cachePath, 'public');

                $this->Cache->set('dvs.image.styled.' . request()->get('s'), $cacheUrl);
            }

            return $image;

        } catch (\Exception $e)
        {
            return Image::make(base_path('vendor/devisephp/cms/resources/images/file-icon.gif'))
                ->response();
        }
    }

    public function getFieldUrl($fieldPath)
    {
        $parts = parse_url($fieldPath);
        if (isset($parts['query']))
        {
            parse_str($parts['query'], $input);

            return $this->Cache
                ->get('dvs.image.styled.' . $input['s'], $fieldPath);
        }

        return $fieldPath;
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
        $filePath = $this->server->makeImage($pathForVisibility, $params);
        $this->Storage->setVisibility($filePath, 'public');

        $signKey = $this->getKey();

        $fileName = pathinfo($path);


        if (!isset($fileName['dirname']) || !isset($fileName['basename'])) abort(400, 'Unable to parse given image path ' . $path);

        $urlBuilder = $this->UrlBuilderFactory
            ->create($fileName['dirname'] . '/', $signKey);

        $url = $urlBuilder->getUrl($fileName['basename'], $params);

        return '/storage/styled' . str_replace('/storage/media', '', $url);
    }

    private function getKey()
    {
        $key = $this->Config->get('devise.media.security.key');

        if ($this->Str->startsWith($key, 'base64:'))
        {
            return substr($key, 7);
        }

        return $key;
    }
}