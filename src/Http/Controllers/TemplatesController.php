<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;
use Devise\Http\Requests\Templates\SaveTemplate;
use Devise\Http\Requests\Templates\DeleteTemplate;
use Devise\Http\Resources\Api\TemplateResource;
use Devise\Models\DvsTemplate;

use Devise\Support\Framework;
use Illuminate\Routing\Controller;

class TemplatesController extends Controller
{
  /**
   * @var DvsTemplate
   */
  private $DvsTemplate;


  /**
   * TemplatesController constructor.
   * @param DvsTemplate $DvsTemplate
   */
  public function __construct(DvsTemplate $DvsTemplate, Framework $Framework)
  {
    $this->DvsTemplate = $DvsTemplate;
    $this->View = $Framework->View;
  }

  public function all(ApiRequest $request)
  {
    $all = $this->DvsTemplate
      ->get();

    return TemplateResource::collection($all);
  }

  public function show(ApiRequest $request, $id)
  {
    $template = $this->DvsTemplate
      ->find($id);

    $template->registerComponents();

    return $this->View->make($template->layout, ['page' => $template]);
  }

  public function store(SaveTemplate $request)
  {
    $new = $this->DvsTemplate
      ->createFromRequest($request);

    return new TemplateResource($new);
  }

  public function update(SaveTemplate $request, $id)
  {
    $template = $this->DvsTemplate
      ->findOrFail($id);

    $template->updateFromRequest($request);

    return new TemplateResource($template);
  }

  public function delete(DeleteTemplate $request, $id)
  {
    $template = $this->DvsTemplate
      ->findOrFail($id);

    if($template->pages->count()) abort(422, 'Template must be removed from all pages before deleting.');

    $template->delete();
  }
}