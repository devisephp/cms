<?php namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;
use Devise\Media\Files\ImageAlts;
use Devise\Media\Files\Manager;
use Devise\Media\Files\Repository;

use Devise\Models\DvsField;
use Devise\Models\DvsSliceInstance;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use League\Glide\ServerFactory;
use League\Glide\Responses\LaravelResponseFactory;

use Devise\Sites\SiteDetector;
use Devise\Support\Framework;

use League\Glide\Signatures\SignatureFactory;
use League\Glide\Urls\UrlBuilderFactory;
use Spatie\ImageOptimizer\OptimizerChain;
use Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser;

/**
 * Class ResponseHandler handles controller part of media manager
 * as far as uploading, renaming and removing media files goes
 *
 * @package Devise\Media\Files
 */
class MediaController extends Controller
{
    use ValidatesRequests;

    protected $FileManager;

    protected $Repository;

    protected $ImageAlts;

    /**
     * Construct a new response handler
     *
     * @param Manager $FileManager
     * @param null $Redirect
     */
    public function __construct(Manager $FileManager, Repository $Repository, SiteDetector $SiteDetector, OptimizerChain $OptimizerChain, ImageAlts $ImageAlts, Framework $Framework)
    {
        $this->FileManager = $FileManager;
        $this->Repository = $Repository;
        $this->SiteDetector = $SiteDetector;
        $this->OptimizerChain = $OptimizerChain;
        $this->ImageAlts = $ImageAlts;

        $this->Auth = $Framework->Auth;
        $this->Config = $Framework->Config;
        $this->Storage = $Framework->storage->disk(config('devise.media.disk'));

        $this->guesser = MimeTypeGuesser::getInstance();
    }

    /**
     *
     * @param Request $request
     * @param $folderPath
     * @return array
     */
    public function all(Request $request, $folderPath = '')
    {
        $input = $request->all();
        $input['category'] = $folderPath;
        $results = $this->Repository->getIndex($input, ['media-items']);

        return $results['media-items'];
    }

    /**
     *
     * @param Request $request
     * @return array
     */
    public function search(Request $request)
    {
        return $this->Repository->buildSearchedItems($request->get('q'));
    }

    /**
     * Requests a file upload
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validate($request, ['file' => 'required|file']);
        $this->FileManager->saveUploadedFile($request->all());
    }

    /**
     * Requests a file removal
     *
     * @param Request $request
     */
    public function remove($mediaRoute)
    {
        $mediaRoute = str_replace('storage', '', $mediaRoute);
        if ($this->Storage->get($mediaRoute))
        {
            $this->FileManager->removeUploadedFile($mediaRoute);
        }
    }

    /**
     * Requests a file upload
     *
     * @param Request $request
     * @return mixed
     */
    public function details($path)
    {
        $sansStoragePath = str_replace('/storage', '', $path);

        return $this->Repository->getFileData($sansStoragePath, true);
    }

    /**
     * Requests a preview of a generated media image
     *
     */
    public function preview(Filesystem $filesystem, $path)
    {
        return $this->getImage($filesystem, str_replace('/storage/media/', '', $path));
    }

    public function show(ApiRequest $request, Filesystem $filesystem, $path)
    {
        if (!$request->has('s')) return $this->tryLegacyStorageFile($path);

        $this->validateSignature($request, '/storage/media/' . $path);

        return $this->getImage($filesystem, $path);
    }

    public function reGenerateAllSignedUrls(ApiRequest $request, $instanceId, $fieldType)
    {
        $instance = DvsSliceInstance::findOrFail($instanceId);
        $allFields = DvsField::join('dvs_slice_instances', 'dvs_slice_instances.id', '=', 'dvs_fields.slice_instance_id')
            ->where('dvs_slice_instances.view', $instance->view)
            ->where('dvs_fields.key', $fieldType)
            ->select('dvs_fields.*')
            ->get();

        $allSizes = $request->get('allSizes');
        $requestedSizes = $request->get('sizes')['sizes'];

        foreach ($allFields as $field)
        {
            $value = array_merge(['media' => []], (array)$field->value);
            $settings = (isset($field->value['settings'])) ? (array)$field->value['settings'] : $this->Config->get('devise.media.settings');

            if ($originalImage = $field->original_image)
            {
                $newSizes = $this->onlyNewSizes($requestedSizes, $field->value['sizes'] ?? []);

                if ($newSizes)
                {
                    $newMediaUrls = $this->getNewMediaSignedURls($originalImage, $settings, $newSizes);

                    if ($newMediaUrls)
                    {
                        $value['url'] = $originalImage;
                        $value['media'] = array_merge((array)$value['media'], $newMediaUrls);
                        $value['sizes'] = $allSizes;

                        $field->json_value = json_encode($value);
                        $field->save();
                    }
                }
            }
        }

    }

    public function generateSignedUrls(ApiRequest $request)
    {
        $originalPath = $request->get('original');
        $settings = $request->get('settings');
        $sizes = [];
        if (isset($settings['sizes'])) {
            $sizes = $settings['sizes'];
            unset($settings['sizes']);
        }

        $newMediaUrls = $this->getNewMediaSignedURls($originalPath, $settings, $sizes);

        return [
            'images'   => $newMediaUrls,
            'settings' => $settings,
            'alt'      => $this->ImageAlts->get($originalPath)
        ];
    }

    public function getNewMediaSignedURls($originalPath, $settings, $sizes)
    {
        $newMediaUrls = [
            'original'       => $originalPath,
            'orig_optimized' => $this->generateSignedUrl($originalPath, $settings)
        ];

        foreach ($sizes as $name => $size)
        {
            unset($size['breakpoints']);

            $sizeSettings = array_merge($settings, $size);
            $newMediaUrls[$name] = $this->generateSignedUrl($originalPath, $sizeSettings);
        }

        return $newMediaUrls;
    }

    private function getImage(Filesystem $filesystem, $path)
    {
        $type = $this->guesser->guess($this->Storage->path('/media/' . $path));

        if (strpos($type, 'image') !== false)
        {
            try
            {
                $server = $this->initGlideServer($filesystem);

                $sourceDirectory = 'public/' . $this->Config->get('devise.media.source-directory') . '/';

                return $server->getImageResponse($sourceDirectory . $path, request()->all());

            } catch (\Exception $e)
            {
            }
        }

        return Image::make(base_path('vendor/devisephp/cms/resources/images/file-icon.gif'))->response();
    }

    private function initGlideServer(Filesystem $filesystem)
    {
        return ServerFactory::create([
            'response'               => new LaravelResponseFactory(app('request')),
            'source'                 => $filesystem->getDriver(),
            'cache'                  => storage_path('app/glide'),
            'group_cache_in_folders' => false,
            'base_url'               => '/styled/preview/',
            'driver'                 => $this->Config->get('devise.media.driver')
        ]);
    }

    private function validateSignature(ApiRequest $request, $path)
    {
        $signKey = $this->getKey();

        SignatureFactory::create($signKey)
            ->validateRequest($path, $request->all());
    }

    private function generateSignedUrl($path, $params)
    {
        $signKey = $this->getKey();

        $fileName = pathinfo($path);

        if (!isset($fileName['dirname']) && !isset($fileName['basename'])) abort(400, 'Unable to parse given image path ' . $path);

        $urlBuilder = UrlBuilderFactory::create($fileName['dirname'] . '/', $signKey);

        $url = $urlBuilder->getUrl($fileName['basename'], $params);

        return '/storage/styled' . str_replace('/storage/media', '', $url);
    }

    private function tryLegacyStorageFile($path)
    {
        if ($this->Storage->exists('/styled/' . $path))
        {
            return Image::make($this->Storage->path('/styled/' . $path))->response();
        }

        abort(404, $path . ' not found');
    }

    private function onlyNewSizes($requestedSizes, $sizes)
    {
        $sizes = (array)$sizes;
        foreach ($requestedSizes as $sizeName => $requestedSize)
        {
            $skipSizeByRemoving = false;
            if (isset($sizes[$sizeName]) &&
                isset($sizes[$sizeName]->w) &&
                isset($sizes[$sizeName]->h) &&
                isset($requestedSize['w']) &&
                isset($requestedSize['h']))
            {
                // all properties were found to compare
                if ($sizes[$sizeName]->w == $requestedSize['w'] && $sizes[$sizeName]->h == $requestedSize['h'])
                {
                    $skipSizeByRemoving = true;
                }
            }
            if ($skipSizeByRemoving) unset($requestedSizes[$sizeName]);
        }

        return $requestedSizes;
    }

    private function getKey()
    {
        $key = $this->Config->get('devise.media.security.key');
        if (Str::startsWith($key, 'base64:'))
        {
            return substr($key, 7);
        }

        return $key;
    }
}