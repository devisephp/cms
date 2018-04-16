<?php

namespace Devise\Http\Controllers;

use Devise\Models\DvsPage;
use Devise\Http\Requests\ApiRequest;
use Devise\Support\Framework;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
  private $View;

  /**
   * AdminController constructor.
   * @param DvsPage $DvsPage
   * @param Framework $Framework
   */
  public function __construct(DvsPage $DvsPage, Framework $Framework)
  {
    $this->DvsPage = $DvsPage;
    $this->View = $Framework->View;
  }

  public function show(ApiRequest $request)
  {
    $pages = $this->DvsPage->get();
    if ($pages->count() < 1) {
      return $this->View->make('devise::admin.temporary-admin');
    }
  }

}
