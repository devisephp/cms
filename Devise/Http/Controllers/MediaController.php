<?php namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;
use Devise\Media\Files\ImageAlts;
use Devise\Media\Files\Manager;
use Devise\Media\Directories\Manager as CategoriesManager;
use Devise\Media\Files\Repository;
use Devise\Media\Glide;
use Devise\Models\DvsField;
use Devise\Models\DvsSliceInstance;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Support\Arr;
use Intervention\Image\Facades\Image;

use Devise\Support\Framework;

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

    protected $Glide;

    protected $Config;

    protected $Storage;

    /**
     * Construct a new response handler
     *
     * @param Manager $FileManager
     * @param Repository $Repository
     * @param ImageAlts $ImageAlts
     * @param Glide $Glide
     * @param Framework $Framework
     */
    public function __construct(Manager $FileManager, Repository $Repository, ImageAlts $ImageAlts, Glide $Glide, Framework $Framework)
    {
        $this->FileManager = $FileManager;
        $this->Repository = $Repository;
        $this->ImageAlts = $ImageAlts;
        $this->Glide = $Glide;

        $this->Config = $Framework->Config;
        $this->Storage = $Framework->storage->disk(config('devise.media.disk'));
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
     * @throws \Illuminate\Validation\ValidationException
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
    public function preview($path)
    {
        if (strpos($path, 'http') !== false && strpos($path, '/' . config('devise.media.source-directory')) !== false)
        {
            $path = strstr($path, config('devise.media.source-directory') . '/');
            $path = str_replace(config('devise.media.source-directory') . '/', '', $path);
        }

        if (strpos($path, '/styled/') !== false)
        {
            $path = str_replace('/styled/', '/media/', $path);
        }

        $path = str_replace('/storage/media/', '', $path);
        $path = str_replace('storage/media/', '', $path);

        return $this->Glide
            ->getImageResponse(str_replace('/storage/media/', '', $path));
    }

    public function show(ApiRequest $request, $path)
    {
        if (!$request->has('s')) return $this->tryLegacyStorageFile($path);

        $this->Glide
            ->validateSignature('/storage/media/' . $path, $request->all());

        return $this->Glide
            ->getImageResponse($path);
    }

    public function generateSignedUrls(ApiRequest $request)
    {
        $sizes = $request->get('sizes');

        $newMediaUrls = [];
        foreach ($sizes as $name => $sizeSettings)
        {
            $settings = (array)$sizeSettings;

            $imagePath = $this->alterInvalidPaths($settings['url']);

            $settings = Arr::except($settings, ['url', 'breakpoints']);

            $newMediaUrls[$name] = $this->Glide->generateSignedUrl($imagePath, $settings);
        }

        return [
            'media'        => $newMediaUrls,
            'defaultImage' => $request->get('defaultImage'),
            'alt'          => $this->ImageAlts->get($request->get('defaultImage'))
        ];
    }

    public function reGenerateAllSignedUrls(ApiRequest $request, $instanceId, $fieldKey)
    {
        $instance = DvsSliceInstance::find($instanceId);
        if ($instance)
        {
            $allFields = DvsField::join('dvs_slice_instances', 'dvs_slice_instances.id', '=', 'dvs_fields.slice_instance_id')
                ->where('dvs_slice_instances.view', $instance->view)
                ->where('dvs_fields.key', $fieldKey)
                ->select('dvs_fields.*')
                ->get();

            $requestedSizes = $request->get('sizes')['sizes'];
            foreach ($allFields as $field)
            {
                $field->shouldMutateJson = false;
                $value = array_merge(['media' => []], (array)$field->value);

                $defaultImage = $field->original_image;
                $defaultSettings = config('devise.media.default-settings');

                $allSizes = array_keys((array)$value['media']);
                foreach ($requestedSizes as $name => $settings)
                {
                    $newSize = !in_array($name, $allSizes);
                    if (!$newSize)
                    {
                        $parts = parse_url($value['media']->$name);
                        $path = $parts['path'] ?? [];
                        parse_str($parts['query'], $params);

                        if ($this->sizeHasChanged($settings, $params))
                        {
                            $params['w'] = $settings['w'];
                            $params['h'] = $settings['h'];
                            $value['media']->$name = $this->Glide->generateSignedUrl($path, $params);
                        }
                    } else
                    {
                        $defaultSettings['w'] = $settings['w'];
                        $defaultSettings['h'] = $settings['h'];
                        $value['media']->$name = $this->Glide->generateSignedUrl($defaultImage, $defaultSettings);
                    }
                }

                $field->value = json_encode($value);
                $field->save();
            }
        }
    }

    private function tryLegacyStorageFile($path)
    {
        if ($this->Storage->exists('/styled/' . $path))
        {
            return Image::make($this->Storage->path('/styled/' . $path))->response();
        }

        abort(404, $path . ' not found');
    }

    private function sizeHasChanged($requestedSize, $currentSize)
    {
        if (!$this->hasWidthAndHeight($requestedSize) || !$this->hasWidthAndHeight($requestedSize)) return true;

        if ($currentSize['w'] != $requestedSize['w'] || $currentSize['h'] != $requestedSize['h']) return true;

        return false;
    }

    private function alterInvalidPaths($path)
    {
        if (filter_var($path, FILTER_VALIDATE_URL) && strpos($path, '/' . config('devise.media.source-directory')) !== false)
        {
            $parts = parse_url($path);
            if (isset($parts['path']))
            {
                $path = '/storage' . $parts['path'];
            }
        }

        if (strpos($path, '/storage/styled') === 0)
        {
            $path = str_replace('/storage/styled', '/storage/' . config('devise.media.source-directory'), $path);
        }

        return $path;
    }

    private function hasWidthAndHeight($settings)
    {
        $required = ['w', 'h'];

        return count(array_intersect_key(array_flip($required), $settings)) === count($required);
    }
}