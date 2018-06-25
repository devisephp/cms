<?php namespace Devise\Http\Controllers;

use Devise\Media\Files\Manager;
use Devise\Media\Files\Repository;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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
  public function __construct(Manager $FileManager, Repository $Repository)
  {
    $this->FileManager = $FileManager;
    $this->Repository = $Repository;
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

    $file = $this->FileManager->saveUploadedFile($request->all());

    return $this->Repository->getFileData($file);
  }

  /**
   * Requests a file removal
   *
   * @param Request $request
   */
  public function remove(Request $request, $mediaId)
  {
    $this->FileManager->removeUploadedFile($mediaId);
  }
}