<?php namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;
use Devise\Media\Files\Manager;
use Devise\Media\Files\Repository;

use Devise\Models\DvsField;
use Devise\Models\DvsSliceInstance;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Contracts\Filesystem\Filesystem;
use League\Glide\ServerFactory;
use League\Glide\Responses\LaravelResponseFactory;

use Devise\Sites\SiteDetector;
use Devise\Support\Framework;

use Spatie\ImageOptimizer\OptimizerChain;

/**
 * Class ResponseHandler handles controller part of media manager
 * as far as uploading, renaming and removing media files goes
 *
 * @package Devise\Media\Files
 */
class MediaController extends Controller
{
    use ValidatesRequests;
    /**
     * @var Manager
     */
    protected $FileManager;
    protected $Repository;

    /**
     * Construct a new response handler
     *
     * @param Manager $FileManager
     * @param null $Redirect
     */
    public function __construct(Manager $FileManager, Repository $Repository, SiteDetector $SiteDetector, OptimizerChain $OptimizerChain, Framework $Framework)
    {
        $this->FileManager = $FileManager;
        $this->Repository = $Repository;
        $this->SiteDetector = $SiteDetector;
        $this->Config = $Framework->Config;
        $this->Storage = $Framework->storage->disk(config('devise.media.disk'));
        $this->OptimizerChain = $OptimizerChain;
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
    public function searchable(Request $request)
    {
        return $this->Repository->buildSearchableMediaItems();
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
        if ($this->Storage->get($mediaRoute)) {
            $this->FileManager->removeUploadedFile($mediaRoute);
        }
    }

    /**
     * Requests a preview of a generated media image
     *
     * @param Filesystem $filesystem
     * @param String $path Path of the source media file
     */
    public function preview(Filesystem $filesystem, $path)
    {
        $server = ServerFactory::create([
            'response'               => new LaravelResponseFactory(app('request')),
            'source'                 => $filesystem->getDriver(),
            'cache'                  => $filesystem->getDriver(),
            'group_cache_in_folders' => false,
            'base_url'               => '/styled/preview/'
        ]);
        $sourceDirectory = 'public/' . $this->Config->get('devise.media.source-directory') . '/';
        $path = str_replace("media/", '', $path);
        $path = str_replace("storage/", '', $path);

        return $server->getImageResponse($sourceDirectory . $path, request()->all());
    }

    public function reGenerateAll(ApiRequest $request, $instanceId, $fieldType)
    {
        $instance = DvsSliceInstance::findOrFail($instanceId);
        $allFields = DvsField::join('dvs_slice_instances', 'dvs_slice_instances.id', '=', 'dvs_fields.slice_instance_id')
            ->where('dvs_slice_instances.view', $instance->view)
            ->where('dvs_fields.key', $fieldType)
            ->select('dvs_fields.*')
            ->get();

        foreach ($allFields as $field)
        {
            $value = (array)$field->value;
            $settings = (isset($field->value->settings)) ? (array)$field->value->settings : [];
            $settings['sizes'] = $request->get('sizes');

            if (isset($field->value->media) && isset($field->value->media->original))
            {
                $originalImage = (string)$field->value->media->original;
                $imagesAndSettings = $this->getImagesToMakeAndSettings($field->value->media->original, $settings);

                $result = $this->generateAll($originalImage, $imagesAndSettings);
                $value['url'] = $result['images']['orig_optimized'];
                $currentMedia = (array) $value['media'];
                $value['media'] = array_merge($currentMedia, $result['images']);
                $field->json_value = json_encode($value);
                $field->save();
            }
        }
    }

    public function generate(ApiRequest $request)
    {
        $originalImage = $request->get('original');
        $imagesAndSettings = $this->getImagesToMakeAndSettings($originalImage, $request->get('settings'));

        return $this->generateAll($originalImage, $imagesAndSettings);
    }

    public function generateAll($original, $imagesAndSettings)
    {
        $finalImages = [];
        $finalImageUrls = ['original' => $original];

        $site = $this->SiteDetector->current();
        $sourceDirectory = 'app/public/';
        $original = str_replace("storage/", '', $original);
        $sourceImage = storage_path($sourceDirectory . $original);


        
        $destinationDirectory = dirname($this->Config->get('devise.media.cached-images-directory') . '/' . $site->domain . str_replace("media/", '', $original));
        $this->Storage->makeDirectory($destinationDirectory);

        foreach ($imagesAndSettings['images'] as $sizeLabel => $sizeSettings)
        {
            $append = $this->getNameAppend($sizeSettings);
            $destinationImage = $this->buildDestinationImagePath($destinationDirectory, basename($original), $append);
            $destinationImageUrl = $this->buildDestinationImageUrl($original, basename($original), $append);

            $finalImageUrls[$sizeLabel] = $destinationImageUrl;

            $finalSettings = array_merge($sizeSettings, $imagesAndSettings['settings']);

            // TODO: Can we catch memory timeouts here a little better? 
            $finalImages[] = \GlideImage::create($sourceImage)
                                ->modify($finalSettings)
                                ->save($destinationImage);
            
        }

        $this->optimizeImages($finalImages);

        if(isset($imagesAndSettings['settings']['sizes'])){
            unset($imagesAndSettings['settings']['sizes']);
        }

        return [
            'images'   => $finalImageUrls,
            'settings' => $imagesAndSettings['settings']
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

        return $destinationUrlParts['dirname'] . '/' . $destinationUrlParts['filename'] . $append . '.' . strtolower($destinationUrlParts['extension']);
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
        return md5(json_encode($settings));
    }

    private function getImagesToMakeAndSettings($original, $settings)
    {
        $sizes = array_get($settings, 'sizes', []);

        $imagesToMake['orig_optimized'] = $settings;

        foreach ($sizes as $sizeLabel => $size)
        {
            $imagesToMake[$sizeLabel] = ['w' => $size['w'], 'h' => $size['h']];
        }

        return ['images' => $imagesToMake, 'settings' => $settings];
    }
}