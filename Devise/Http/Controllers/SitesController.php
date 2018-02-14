<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;
use Devise\Http\Requests\Sites\SaveSite;
use Devise\Http\Requests\Sites\DeleteSite;
use Devise\Http\Resources\Api\SiteResource;
use Devise\Models\DvsSite;

use Illuminate\Routing\Controller;

class SitesController extends Controller
{
  /**
   * @var DvsSite
   */
  private $DvsSite;


  /**
   * SitesController constructor.
   * @param DvsSite $DvsSite
   */
  public function __construct(DvsSite $DvsSite)
  {
    $this->DvsSite = $DvsSite;
  }

  public function all(ApiRequest $request)
  {
    $all = $this->DvsSite
      ->with('languages')
      ->get();

    return SiteResource::collection($all);
  }

  /**
   * @param SaveSite $request
   * @return SiteResource
   */
  public function store(SaveSite $request)
  {
    $new = $this->DvsSite
      ->createFromRequest($request);

    return new SiteResource($new);
  }

  /**
   * @param SaveSite $request
   * @param $id
   * @return SiteResource
   */
  public function update(SaveSite $request, $id)
  {
    $template = $this->DvsSite
      ->findOrFail($id);

    $template->updateFromRequest($request);

    $syncdata = $this->getLanguageSyncData($request->input('languages', []));

    $template->languages()->sync($syncdata);

    $template->load('languages');

    return new SiteResource($template);
  }

  /**
   * @param DeleteSite $request
   * @param $id
   */
  public function delete(DeleteSite $request, $id)
  {
    $template = $this->DvsSite
      ->findOrFail($id);

    $template->delete();
  }

  private function getLanguageSyncData($languages)
  {
    $languages = collect($languages);
    $languages = $languages->keyBy('id');

    return $languages->map(function ($language) {
      return ['default' => $language['default']];
    });
  }
}