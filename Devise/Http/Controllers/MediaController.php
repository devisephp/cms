<?php namespace Devise\Http\Controllers;

use Devise\Media\Files\Manager;
use Devise\Media\Files\Repository;

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
     * Requests a file upload
     *
     * @param Request $request
     * @param $folderPath
     * @return mixed
     */
    public function all(Request $request, $folderPath = '')
    {
        $input = $request->all();
        $input['category'] = $folderPath;
        $results = $this->Repository->getIndex($input, ['media-items']);

        return $results['media-items'];
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
    public function remove(Request $request, $mediaId)
    {
        $this->FileManager->removeUploadedFile($request->all());
    }

  /**
   * Requests a preview of a generated media image
   * 
   * @param Filesystem $filesystem
   * @param String $path Path of the source media file
   */
  public function preview (Filesystem $filesystem, $path)
  {
      $server = ServerFactory::create([
          'response' => new LaravelResponseFactory(app('request')),
          'source' => $filesystem->getDriver(),
          'cache' => $filesystem->getDriver(),
          'group_cache_in_folders' => false,
          'base_url' => 'styled/preview/'
      ]);

      $site = $this->SiteDetector->current();
      $sourceDirectory = 'public/' . $this->Config->get('devise.media.source-directory') . '/';
      $path = str_replace("media/", '', $path);
      $path = str_replace("storage/", '', $path);

      return $server->getImageResponse($sourceDirectory . $path, request()->all());
  }

  public function generate(Filesystem $filesystem, $path)
  {
    $finalImages = [];
    $finalImageUrls = [];
    $urlParts = explode('|||', $path);
    $imagesAndSettings = $this->getImagesToMakeAndSettings($urlParts[1]);
    
    $site = $this->SiteDetector->current();
    $sourceDirectory = 'app/public/';
    $urlParts[0] = str_replace("storage/", '', $urlParts[0]);
    $sourceImage = storage_path($sourceDirectory . $urlParts[0]);
    
    $destinationDirectory = dirname($this->Config->get('devise.media.cached-images-directory') . '/' . $site->domain . str_replace("media/", '', $urlParts[0]));
    $this->Storage->makeDirectory($destinationDirectory);

    foreach($imagesAndSettings['images'] as $sizeLabel => $image) {
      $destinationImage = $this->buildDestinationImagePath($destinationDirectory, basename($urlParts[0]), $image);
      $destinationImageUrl = $this->buildDestinationImageUrl($urlParts[0], basename($urlParts[0]), $image);

      $finalImageUrls[$sizeLabel] = $destinationImageUrl;

      $image = array_merge($image, $imagesAndSettings['settings']);

      $finalImages[] = \GlideImage::create($sourceImage)
        ->modify($image)
        ->save($destinationImage);
    }

    $this->optimizeImages($finalImages);

    return [
      'images' => $finalImageUrls,
      'settings' => $imagesAndSettings['settings']
    ];
  }

  private function optimizeImages($images) {
    $optimize = function ($image) {
      $this->OptimizerChain->optimize($image);
    };

    array_map($optimize, $images);
  }

  private function buildDestinationImagePath ($destinationDirectory, $originalImageName, $image) {
    
    $destinationImage = storage_path('app/public/' . $destinationDirectory . '/' . $originalImageName);
    $destinationPathParts = pathinfo($destinationImage);
    $sizeAppend = $this->getSizeNameAppend($image);
    $hashAppend = $this->getHashNameAppend($image);

    return $destinationPathParts['dirname'] . '/' . $destinationPathParts['filename'] . $sizeAppend . '-' . $hashAppend . '.' . strtolower($destinationPathParts['extension']);
  }

  private function buildDestinationImageUrl ($file, $originalImageName, $image) {
    $site = $this->SiteDetector->current();
    $destinationUrl = dirname($this->Config->get('devise.media.cached-images-directory') . '/' . $site->domain . str_replace("media/", '', $file)) . '/' . $originalImageName;
    $destinationUrlParts = pathinfo($destinationUrl);
    $sizeAppend = $this->getSizeNameAppend($image);
    $hashAppend = $this->getHashNameAppend($image);

    return $destinationUrlParts['dirname'] . '/' . $destinationUrlParts['filename'] . $sizeAppend . '-' . $hashAppend  . '.' . strtolower($destinationUrlParts['extension']);
  }

  private function getSizeNameAppend ($image) {
    $sizeAppend = '';
    if (isset($image['w'])) {
      $sizeAppend = '-' . $image['w'] . '-' . $image['h'];
    }

    return $sizeAppend;
  }

  private function getHashNameAppend ($image) {
    return md5(json_encode($image));
  }


  private function getImagesToMakeAndSettings($settingsString) {
    if ($settingsString === null) {
      $imagesToMake['original'] = null;
      return ['images' => $imagesToMake, 'settings' => null];
    }

    $settings = json_decode($settingsString, true);
    $sizes = array_pull($settings, 'sizes');
    
    $imagesToMake['original'] = $settings;
    if ($sizes != null) {
      foreach($sizes as $sizeLabel => $size) {
        $imagesToMake[$sizeLabel] = ['w' => $size['w'], 'h' => $size['h']];
      }
    }

    return ['images' => $imagesToMake, 'settings' => $settings];
  }
}