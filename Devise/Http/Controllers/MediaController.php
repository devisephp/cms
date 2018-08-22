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

<<<<<<< HEAD
  /**
   * Construct a new response handler
   *
   * @param Manager $FileManager
   * @param null $Redirect
   */
  public function __construct(Manager $FileManager, Repository $Repository, SiteDetector $SiteDetector, Framework $Framework)
  {
    $this->FileManager = $FileManager;
    $this->Repository = $Repository;
    $this->SiteDetector = $SiteDetector;
    $this->Config = $Framework->Config;
  }
=======
    /**
     * Construct a new response handler
     *
     * @param Manager $FileManager
     * @param null $Redirect
     */
    public function __construct(Manager $FileManager, Repository $Repository)
    {
        $this->FileManager = $FileManager;
        $this->Repository = $Repository;
    }
>>>>>>> 387bdd415b1611b5176d0ae63a5ff702c8922104

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
    $urlParts = explode('|||', $path);
    $modifierArray = $this->buildModifierArray($urlParts[1]);
    $site = $this->SiteDetector->current();

    $sourceDirectory = 'app/public/' . $this->Config->get('devise.media.source-directory') . '/' . $site->domain . '/';
    $sourceImage = storage_path($sourceDirectory . $urlParts[0]);

    $destinationDirectory = 'app/public/' . $this->Config->get('devise.media.cached-images-directory') . '/' . $site->domain;
    $destinationImage = storage_path($destinationDirectory . '/' . $path);

    // dd(storage_path($destinationDirectory));
    \Storage::makeDirectory(storage_path($destinationDirectory));

    \GlideImage::create($sourceImage)
      ->modify($modifierArray)
      ->save($destinationImage);


      // $server = ServerFactory::create([
      //     'response' => new LaravelResponseFactory(app('request')),
      //     'source' => $filesystem->getDriver(),
      //     'cache' => $filesystem->getDriver(),
      //     'cache_path_prefix' => '.cache',
      // ]);

      // return $server->getImageResponse($path, request()->all());
  }

  private function buildModifierArray($settingsString) {
    $settings = explode(',', $settingsString);

    $modifierArray = [];
    foreach($settings as $setting) {
      $setting = explode('=', $setting);
      $modifierArray[$setting[0]] = $setting[1];
    }

    return $modifierArray;
  }
}