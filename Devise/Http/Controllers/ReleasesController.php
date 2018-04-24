<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;

use Devise\MotherShip\Releases;
use Illuminate\Routing\Controller;

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

  public function send(ApiRequest $request)
  {
    $this->Releases->sendAndSync($request->all());
  }
}
