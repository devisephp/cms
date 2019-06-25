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

        $data = json_decode("{
  \"sizes\":{
     \"original\":{
        \"url\":\"/storage/media/atlantis-new-arieal-300dpi.jpg\",
        \"w\":4000,
        \"h\":2250,
        \"q\":80,
        \"fit\":\"crop\",
        \"sharp\":5,
        \"breakpoints\":[
           \"desktop\",
           \"largeDesktop\",
           \"ultraWideDesktop\"
        ]
     },
     \"large\":{
        \"url\":\"/storage/media/atlantis-new-arieal-300dpi.jpg\",
        \"w\":480,
        \"h\":480,
        \"breakpoints\":[
           \"desktop\",
           \"largeDesktop\",
           \"ultraWideDesktop\"
        ]
     },
     \"small\":{
        \"url\":\"/storage/media/atlantis-new-arieal-300dpi.jpg\",
        \"w\":360,
        \"h\":360,
        \"q\":80,
        \"fit\":\"crop\",
        \"sharp\":5,
        \"breakpoints\":[
           \"tablet\",
           \"mobile\"
        ]
     }
  }
}");
        /*
{
  "sizes":{
     "original":{
        "url":"/storage/media/atlantis-new-arieal-300dpi.jpg",
        "w":4000,
        "h":2250,
        "q":80,
        "fit":"crop",
        "sharp":5,
        "breakpoints":[
           "desktop",
           "largeDesktop",
           "ultraWideDesktop"
        ]
     },
     "large":{
        "url":"/storage/media/atlantis-new-arieal-300dpi.jpg",
        "w":480,
        "h":480,
        "q":80,
        "fit":"crop",
        "sharp":5,
        "breakpoints":[
           "desktop",
           "largeDesktop",
           "ultraWideDesktop"
        ]
     },
     "small":{
        "url":"/storage/media/atlantis-new-arieal-300dpi.jpg",
        "w":360,
        "h":360,
        "q":80,
        "fit":"crop",
        "sharp":5,
        "breakpoints":[
           "tablet",
           "mobile"
        ]
     }
  }
}

{
   "images":{
      "optimized":"\/storage\/styled\/atlantis-new-arieal-300dpi.jpg?q=80&fit=crop&sharp=5&w=4000&h=2250&s=4038fd16b549d76e87f6c63f5576dee0",
      "large":"\/storage\/styled\/atlantis-new-arieal-300dpi.jpg?q=80&fit=crop&sharp=5&w=480&h=480&s=361e7e7a3420ac93dcd897e310cb60b9",
      "small":"\/storage\/styled\/atlantis-new-arieal-300dpi.jpg?q=80&fit=crop&sharp=5&w=360&h=360&s=3908119c94df3f26ad237fb17dd13476"
   },
   "settings":{ // going away
      "q":80,
      "fit":"crop",
      "sharp":5,
      "w":4000,
      "h":2250
   },
   "alt":"Drone shot of property"
}
         */
        $sizes = $data['sizes'];
//        $sizes = $request->get('sizes');

        $originalSettings = $sizes['original'];

        foreach ($sizes as $sizeSettings)
        {
            $settings = array_merge($originalSettings, $sizeSettings);
            $imagePath = $settings['url'];

            if (filter_var($imagePath, FILTER_VALIDATE_URL) && strpos($imagePath, '/' . config('devise.media.source-directory')) !== false)
            {
                $parts = parse_url($imagePath);
                if (isset($parts['path']))
                {
                    $imagePath = '/storage' . $parts['path'];
                }
            }

            if (strpos($imagePath, '/storage/styled') === 0)
            {
                $imagePath = str_replace('/storage/styled', '/storage/' . config('devise.media.source-directory'), $imagePath);
            }

            $settings = $request->get('settings');
            $sizes = [];
            if (isset($settings['sizes']))
            {
                $sizes = $settings['sizes'];
                unset($settings['sizes']);
            }

            $newMediaUrls = $this->getNewMediaSignedURls($imagePath, $settings, $sizes);

        }

        return [
            'images'   => $newMediaUrls,
            'settings' => $settings,
            'alt'      => $this->ImageAlts->get($originalPath)
        ];
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
            $field->shouldMutateJson = false;
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

    private function getNewMediaSignedURls($imagePath, $settings, $sizes)
    {
        $newMediaUrls = [
            'original'       => $this->Glide->generateSignedUrl($imagePath, []),
            'orig_optimized' => $this->Glide->generateSignedUrl($imagePath, $settings)
        ];

        foreach ($sizes as $name => $size)
        {
            unset($size['breakpoints']);

            $sizeSettings = array_merge($settings, $size);
            $newMediaUrls[$name] = $this->Glide->generateSignedUrl($imagePath, $sizeSettings);
        }

        return $newMediaUrls;
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
}