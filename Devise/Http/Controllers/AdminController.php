<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;
use Devise\Support\Framework;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
  private $View;

  /**
   * AdminController constructor.
   * @param Framework $Framework
   */
  public function __construct(Framework $Framework)
  {
    $this->View = $Framework->View;
  }

  public function show(ApiRequest $request)
  {
    return $this->View->make('devise::introduction');
  }

}
