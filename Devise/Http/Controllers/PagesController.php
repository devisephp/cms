<?php

namespace Devise\Http\Controllers;

use Devise\Devise;
use Devise\Http\Requests\ApiRequest;
use Devise\Http\Requests\Pages\CopyPage;
use Devise\Http\Requests\Pages\StorePage;
use Devise\Http\Requests\Pages\UpdatePage;
use Devise\Http\Resources\Api\PageResource;
use Devise\Pages\PagesManager;
use Devise\Pages\PagesRepository;
use Devise\Sites\SiteDetector;
use Devise\Support\Framework;

use Illuminate\Routing\Controller;

class PagesController extends Controller
{
    protected $PagesRepository;

    private $PagesManager;

    private $SiteDetector;

    private $Redirect;

    private $View;

    private $Request;

    private $Route;

    /**
     * Creates a new DvsPagesController instance.
     *
     * @param  PagesRepository $PagesRepository
     * @param Framework $Framework
     */
    public function __construct(PagesRepository $PagesRepository, PagesManager $PagesManager, SiteDetector $SiteDetector, Framework $Framework)
    {
        $this->PagesRepository = $PagesRepository;
        $this->PagesManager = $PagesManager;
        $this->SiteDetector = $SiteDetector;

        $this->Redirect = $Framework->Redirect;
        $this->View = $Framework->View;
        $this->Request = $Framework->Request;
        $this->Route = $Framework->Route;
    }

    /**
     * Displays details of a page
     *
     * @return Response
     */
    public function show(ApiRequest $request)
    {
        $page = $this->PagesRepository->findByRouteName($this->Route->currentRouteName());

        $localized = $this->PagesRepository->findLocalizedPage($page);

        if ($localized)
        {
            $route = $this->Route->getCurrentRoute();
            $params = $route ? $route->parameters() : [];

            return $this->Redirect->route($localized->route_name, $params);
        } else
        {
            if (!$page->currentVersion) abort(404);

            $page->currentVersion->registerComponents();
            $page->load('site');

            return $this->View->make($page->currentVersion->layout, ['page' => $page]);
        }
    }

    public function getVueData(ApiRequest $request, $pageId)
    {
        $page = $this->PagesRepository->findById($pageId);

        $page->currentVersion->registerComponents();

        return Devise::dataAsArray($page);
    }

    /**
     * Request the page listing
     *
     */
    public function pages(ApiRequest $request)
    {
        $site = $this->SiteDetector->current();

        $defaultLanguage = $site->default_language;

        $languageId = $request->input('language_id', $defaultLanguage->id);

        if($request->get('paginate', true))
        {
            $pages = $this->PagesRepository->pages($site->id, $languageId);
        } else {
            $pages = $this->PagesRepository->all($site->id, $languageId);
        }

        return PageResource::collection($pages);
    }

    /**
     * Request the page listing
     *
     */
    public function pagesList(ApiRequest $request)
    {
        $site = $this->SiteDetector->current();

        $defaultLanguage = $site->default_language;

        $languageId = $request->input('language_id', $defaultLanguage->id);

        $pages = $this->PagesRepository->list($site->id, $languageId);

        return $pages;
    }

    /**
     * Request the page listing
     *
     */
    public function suggestList(ApiRequest $request)
    {
        $term = $request->input('term');

        $site = $this->SiteDetector->current();

        return $this->PagesRepository->getPagesList($term, $site->id);
    }

    /**
     * Request a new page be created
     *
     * @param StorePage $request
     * @return PageResource
     */
    public function store(StorePage $request)
    {
        $site = $this->SiteDetector->current();

        $defaultLanguage = $site->default_language;

        $input = $request->all();
        $input['site_id'] = $site->id;
        $input['language_id'] = $request->input('language_id', $defaultLanguage->id);

        $page = $this->PagesManager->createNewPage($input);

        return new PageResource($page);
    }

    /**
     * Request page be updated with given input
     *
     * @param UpdatePage $request
     * @param  integer $id
     * @return PageResource
     */
    public function update(UpdatePage $request, $id)
    {
        $page = $this->PagesManager->updatePage($id, $request->all());

        $page->load('versions', 'metas');

        return new PageResource($page);
    }

    /**
     * Request page be copied
     *
     * @param CopyPage $request
     * @param  integer $id
     * @return PageResource
     */
    public function copy(CopyPage $request, $id)
    {
        $page = $this->PagesManager->copyPage($id, $request->all());

        $page->load('versions', 'metas');

        return new PageResource($page);
    }

    /**
     * ApiRequest the page be copied to another page (duplicated)
     *
     * @param ApiRequest $request
     * @param  integer $id
     * @return PageResource
     * @todo make this onework
     */
    public function requestCopyPage(ApiRequest $request, $id)
    {
        $page = $this->PagesManager->copyPage($id, $request->all());

        return new PageResource($page);
    }

    /**
     * Request the page be deleted from database
     *
     * @param ApiRequest $request
     * @param  integer $id
     * @return PageResource
     */
    public function delete(ApiRequest $request, $id)
    {
        $this->PagesManager->destroyPage($id);
    }
}
