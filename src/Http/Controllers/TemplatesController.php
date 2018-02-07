<?php

namespace Devise\Http\Controllers;

use App\Http\Controllers\Controller;
use Devise\Models\DvsTemplate;
use Devise\Resources\Api\TemplateResource;

class TemplatesController extends Controller
{

  public function all()
  {
    $all = DvsTemplate::get();

    return TemplateResource::collection($all);
  }
}