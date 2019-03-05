<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;
use Devise\Http\Requests\Pages\StorePageVersion;
use Devise\Http\Requests\Pages\UpdatePageVersion;
use Devise\Http\Resources\Api\PageVersionResource;
use Devise\Models\DvsPageVersion;
use Devise\Pages\PageVersionManager;

use Illuminate\Routing\Controller;

class PageVersionsController extends Controller
{
    protected $PageVersionManager;
    /**
     * @var DvsPageVersion
     */
    private $DvsPageVersion;

    /**
     * Creates a new DvsPagesController instance.
     *
     * @param PageVersionManager $PageVersionManager
     */
    public function __construct(PageVersionManager $PageVersionManager, DvsPageVersion $DvsPageVersion)
    {
        $this->PageVersionManager = $PageVersionManager;

        $this->DvsPageVersion = $DvsPageVersion;
    }

    public function index(ApiRequest $request)
    {
        $pages = $this->DvsPageVersion
            ->join('dvs_pages', 'dvs_pages.id', '=', 'dvs_page_versions.page_id')
            ->join('dvs_languages', 'dvs_languages.id', '=', 'dvs_pages.language_id')
            ->join('dvs_sites', 'dvs_sites.id', '=', 'dvs_pages.site_id');

        $pages = $pages->where('dvs_pages.title', 'LIKE', '%' . $request->get('term') . '%');

        $pages = $pages->select('dvs_page_versions.id', 'dvs_pages.title', 'dvs_sites.name as site_name', 'dvs_languages.code', 'dvs_page_versions.name')
            ->orderBy('dvs_pages.site_id')
            ->take(10)
            ->get();

        $results = [];
        foreach ($pages as $page)
        {
            $results[$page->id] = [
                'id'           => $page->id,
                'site'         => $page->site_name,
                'title'        => $page->title,
                'version_name' => $page->name,
                'language'     => $page->code
            ];
        }

        return $results;
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
