<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;

use Devise\Http\Resources\Api\ReleaseModelResource;
use Devise\MotherShip\Releases;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;

class ReleasesController extends Controller
{
  /**
   * @var Releases
   */
  private $Releases;


  /**
   * ReleasesController constructor.
   * @param Releases $Releases
   */
  public function __construct(Releases $Releases)
  {
    $this->Releases = $Releases;
  }

  public function all(ApiRequest $request)
  {
    $all = $this->Releases->getForDeviseFlow();

    return ReleaseModelResource::collection($all);
  }

  public function send(ApiRequest $request)
  {
    $this->checkIfUpToDate($request);

    $this->Releases->sendAndSync($request->all());
  }

  private function checkIfUpToDate(ApiRequest $request)
  {
    $status = trim(shell_exec('git status'));
    if (strpos($status, 'nothing to commit') === false && !$request->get('force'))
    {
      $error = ValidationException::withMessages([
        'force' => ['Uncommitted changes found. "force" flag is required.']
      ]);

      throw $error;
    }
  }
}
