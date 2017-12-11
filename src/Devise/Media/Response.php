<?php


namespace Devise\Media;


use Devise\Media\Files\Repository;
use Illuminate\Support\Facades\Input;

class Response
{
  /**
   * @var Repository
   */
  private $Repository;

  /**
   * Response constructor.
   * @param Repository $Repository
   */
  public function __construct(Repository $Repository)
  {

    $this->Repository = $Repository;
  }

  public function getDirectories($folderPath)
  {
    $input = Input::all();
    $input['category'] = $folderPath;
    $results = $this->Repository->compileIndexData($input, ['categories']);

    return $results['categories'];
  }

  public function getFiles($folderPath)
  {
    $input = Input::all();
    $input['category'] = $folderPath;
    $results = $this->Repository->compileIndexData($input, ['media-items']);

    return $results['media-items'];
  }
}