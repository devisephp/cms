<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;
use Devise\Http\Requests\Pages\StorePageVersion;
use Devise\Http\Requests\Pages\UpdatePageVersion;
use Devise\Http\Resources\Api\PageVersionResource;
use Devise\Pages\PageVersionManager;

use Illuminate\Routing\Controller;

class PageVersionsController extends Controller
{
  protected $PageVersionManager;

  /**
   * Creates a new DvsPagesController instance.
   *
   * @param PageVersionManager $PageVersionManager
   */
  public function __construct(PageVersionManager $PageVersionManager)
  {
    $this->PageVersionManager = $PageVersionManager;
  }

  /**
   * Request page version be stored
   *
   * @param StorePageVersion $request
   * @return PageVersionResource
   */
  public function copy(StorePageVersion $request)
  {
    $version = $this->PageVersionManager->copyPageVersion($request->input('page_version_id'), $request->input('name'));

    return new PageVersionResource($version);
  }

  /**
   * Request a page version be updated
   *
   * @param UpdatePageVersion $request
   * @param  integer $pageVersionId
   * @return PageVersionResource
   * @internal param array $input
   */
  public function update(UpdatePageVersion $request, $pageVersionId)
  {
    $version = $this->PageVersionManager->update($pageVersionId, $request);

    return new PageVersionResource($version);
  }

  /**
   * Request that the page version sharing be toggled
   *
   * @param ApiRequest $request
   * @param  integer $pageVersionId
   * @return PageVersionResource
   */
  public function toggleSharing(ApiRequest $request, $pageVersionId)
  {
    $version = $this->PageVersionManager->togglePageVersionPreviewShare($pageVersionId);

    return new PageVersionResource($version);
  }

  /**
   * Request page version be destroyed
   *
   * @param ApiRequest $request
   * @param  integer $pageVersionId
   */
  public function delete(ApiRequest $request, $pageVersionId)
  {
    $this->PageVersionManager->destroyPageVersion($pageVersionId);
  }
}
