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
use Intervention\Image\Facades\Image;
use League\Glide\ServerFactory;
use League\Glide\Responses\LaravelResponseFactory;

use Devise\Sites\SiteDetector;
use Devise\Support\Framework;

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
    public function remove(Request $request, $mediaRoute)
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
    public function details(Request $request, $path)
    {
        $sansStoragePath = str_replace('/storage', '', $path);

        return $this->Repository->getFileData($sansStoragePath, true);
    }

    /**
     * Requests a preview of a generated media image
     *
     * @param Filesystem $filesystem
     * @param String $path Path of the source media file
     * @return mixed
     */
    public function preview(Filesystem $filesystem, $path)
    {
        $path = str_replace("storage/", '', $path);

        $type = $this->guesser->guess($this->Storage->path($path));

        if (strpos($type, 'image') !== false)
        {
            try
            {
                $path = str_replace("media/", '', $path);

                $server = ServerFactory::create([
                    'response'               => new LaravelResponseFactory(app('request')),
                    'source'                 => $filesystem->getDriver(),
                    'cache'                  => $filesystem->getDriver(),
                    'group_cache_in_folders' => false,
                    'base_url'               => '/styled/preview/',
                    'driver'                 => $this->Config->get('devise.media.driver')
                ]);
                $sourceDirectory = 'public/' . $this->Config->get('devise.media.source-directory') . '/';

                return $server->getImageResponse($sourceDirectory . $path, request()->all());
            } catch (\Exception $e)
            {
            }
        }

        return Image::make(base_path('vendor/devisephp/cms/resources/images/file-icon.gif'))->response();
    }

    public function reGenerateAll(ApiRequest $request, $instanceId, $fieldType)
    {
        set_time_limit(0);

        $instance = DvsSliceInstance::findOrFail($instanceId);
        $allFields = DvsField::join('dvs_slice_instances', 'dvs_slice_instances.id', '=', 'dvs_fields.slice_instance_id')
            ->where('dvs_slice_instances.view', $instance->view)
            ->where('dvs_fields.key', $fieldType)
            ->select('dvs_fields.*')
            ->get();

        $allSizes = $request->get('allSizes');

        foreach ($allFields as $field)
        {
            $value = array_merge(['media' => []], (array)$field->value);
            $settings = (isset($field->value->settings)) ? (array)$field->value->settings : [];
            $requestedSizes = $request->get('sizes')['sizes'];

            if ((isset($field->value->media) && isset($field->value->media->original)) || (isset($field->value->url) && $field->value->url))
            {
                if (isset($field->value->media) && isset($field->value->media->original))
                {
                    $newSizes = $this->onlyNewSizes($requestedSizes, $field->value);
                } else
                {
                    $newSizes = $requestedSizes;
                }

                if ($newSizes)
                {
                    $settings['sizes'] = $newSizes;
                    $originalImage = ((isset($field->value->media) && isset($field->value->media->original))) ? (string)$field->value->media->original : (string)$field->value->url;
                    $imagesAndSettings = $this->getImagesToMakeAndSettings($settings);

                    try
                    {
                        $result = $this->generateAll($originalImage, $imagesAndSettings);
                    } catch (\Exception $e)
                    {
                        $result = false;
                    }

                    if ($result)
                    {
                        $value['url'] = $result['images']['orig_optimized'];
                        $currentMedia = (array)$value['media'];
                        $value['media'] = array_merge($currentMedia, $result['images']);
                        $value['sizes'] = $allSizes;

                        $field->json_value = json_encode($value);
                        $field->save();
                    }
                }
            }
        }
    }

    public function generate(ApiRequest $request)
    {
        $originalImage = $request->get('original');
        $imagesAndSettings = $this->getImagesToMakeAndSettings($request->get('settings'));

        return $this->generateAll($originalImage, $imagesAndSettings);
    }

    public function generateAll($original, $imagesAndSettings)
    {
        $finalImages = [];
        $finalImageUrls = ['original' => $original];
        $imageAlt = $this->ImageAlts->get($original);

        $site = $this->SiteDetector->current();
        $sourceDirectory = 'app/public';
        $original = str_replace("storage/", '', $original);
        $sourceImage = storage_path($sourceDirectory . $original);

        if (!file_exists($sourceImage))
        {
            return false;
        }

        $destinationDirectory = dirname($this->Config->get('devise.media.cached-images-directory') . '/' . $site->domain . str_replace("media/", '', $original));
        if (!is_dir($destinationDirectory))
        {
            $this->Storage->makeDirectory($destinationDirectory);
        }

        foreach ($imagesAndSettings['images'] as $sizeLabel => $sizeSettings)
        {
            $append = $this->getNameAppend($sizeSettings);
            $destinationImage = $this->buildDestinationImagePath($destinationDirectory, basename($original), $append);
            $destinationImageUrl = $this->buildDestinationImageUrl($original, basename($original), $append);

            $finalImageUrls[$sizeLabel] = $destinationImageUrl;

            $finalSettings = array_merge(['fit' => 'crop', 'q' => 100], $imagesAndSettings['settings'], $sizeSettings);

            // TODO: Can we catch memory timeouts here a little better?
            $finalImages[] = \GlideImage::create($sourceImage)
                ->modify($finalSettings)
                ->save($destinationImage);

        }

        $this->optimizeImages($finalImages);

        if (isset($imagesAndSettings['settings']['sizes']))
        {
            unset($imagesAndSettings['settings']['sizes']);
        }

        return [
            'images'   => $finalImageUrls,
            'settings' => $imagesAndSettings['settings'],
            'alt'      => $imageAlt
        ];
    }

    private function optimizeImages($images)
    {
        $optimize = function ($image) {
            $this->OptimizerChain->optimize($image);
        };

        array_map($optimize, $images);
    }

    private function buildDestinationImagePath($destinationDirectory, $originalImageName, $append)
    {
        $destinationImage = storage_path('app/public/' . $destinationDirectory . '/' . $originalImageName);
        $destinationPathParts = pathinfo($destinationImage);

        return $destinationPathParts['dirname'] . '/' . $destinationPathParts['filename'] . $append . '.' . strtolower($destinationPathParts['extension']);
    }

    private function buildDestinationImageUrl($file, $originalImageName, $append)
    {
        $site = $this->SiteDetector->current();
        $destinationUrl = '/' . dirname($this->Config->get('devise.media.cached-images-directory') . '/' . $site->domain . str_replace("media/", '', $file)) . '/' . $originalImageName;
        $destinationUrlParts = pathinfo($destinationUrl);

        return $this->Storage->url($destinationUrlParts['dirname'] . '/' . $destinationUrlParts['filename'] . $append . '.' . strtolower($destinationUrlParts['extension']));
    }

    private function getNameAppend($settings)
    {
        $sizeAppend = $this->getSizeNameAppend($settings);
        $hashAppend = $this->getHashNameAppend($settings);

        return $sizeAppend . '-' . $hashAppend;
    }

    private function getSizeNameAppend($image)
    {
        $sizeAppend = '';
        if (isset($image['w']))
        {
            $sizeAppend = '-' . $image['w'] . '-' . $image['h'];
        }

        return $sizeAppend;
    }

    private function getHashNameAppend($settings)
    {
        return md5(json_encode($settings)) . time();
    }

    private function getImagesToMakeAndSettings($settings)
    {
        $sizes = array_get($settings, 'sizes', []);

        $imagesToMake['orig_optimized'] = $settings;

        foreach ($sizes as $sizeLabel => $size)
        {
            $imagesToMake[$sizeLabel] = ['w' => $size['w'], 'h' => $size['h']];
        }

        return ['images' => $imagesToMake, 'settings' => $settings];
    }

    private function onlyNewSizes($requestedSizes, $value)
    {
        if (isset($value->sizes))
        {
            $sizes = (array)$value->sizes;
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

        return $requestedSizes;
    }
}