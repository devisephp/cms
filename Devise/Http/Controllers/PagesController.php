<?php

namespace Devise\Http\Controllers;

use Devise\Devise;
use Devise\Http\Requests\ApiRequest;
use Devise\Http\Requests\Pages\CopyPage;
use Devise\Http\Requests\Pages\StorePage;
use Devise\Http\Requests\Pages\UpdatePage;
use Devise\Http\Resources\Api\RouteResource;
use Devise\Http\Resources\Api\PageResource;
use Devise\Pages\PagesManager;
use Devise\Pages\PagesRepository;
use Devise\Sites\SitesRepository;
use Devise\Sites\SiteDetector;
use Devise\Support\Framework;

use Illuminate\Routing\Controller;

class PagesController extends Controller
{
    protected $PagesRepository;

    private $PagesManager;

    private $SiteDetector;

    private $SitesRepository;

    private $Artisan;

    private $Redirect;

    private $View;

    private $Request;

    private $Route;

    /**
     * Creates a new DvsPagesController instance.
     *
     * @param  PagesRepository $PagesRepository
     * @param PagesManager $PagesManager
     * @param SiteDetector $SiteDetector
     * @param SitesRepository $SitesRepository
     * @param Framework $Framework
     */
    public function __construct(PagesRepository $PagesRepository, PagesManager $PagesManager, SiteDetector $SiteDetector, SitesRepository $SitesRepository, Framework $Framework)
    {
        $this->PagesRepository = $PagesRepository;
        $this->SitesRepository = $SitesRepository;
        $this->PagesManager = $PagesManager;
        $this->SiteDetector = $SiteDetector;

        $this->Artisan = $Framework->Artisan;
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

        if (!$page->currentVersion) abort(404);

        $page->currentVersion->registerComponents();

        return $this->View->make($page->currentVersion->layout, ['page' => $page]);
    }

    public function single(ApiRequest $request, $pageId)
    {
        $page = $this->PagesRepository->findById($pageId);

        $resource = new PageResource($page);

        return [
            'page' => $resource->toArray(request())
        ];
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

        if ($request->get('paginate', true))
        {
            $pages = $this->PagesRepository->pages($site->id, $languageId);
        } else
        {
            $pages = $this->PagesRepository->all($site->id, $languageId);
        }

        return PageResource::collection($pages);
    }

    /**
     * Request the page listing
     *
     */
    public function routes(ApiRequest $request)
    {
        $site = $this->SiteDetector->current();

        $defaultLanguage = $site->default_language;

        $languageId = $request->input('language_id', $defaultLanguage->id);

        $pages = $this->PagesRepository->routes($site->id, $languageId);

        return RouteResource::collection($pages);
    }

    /**
     * Request the page listing
     *
     */
    public function search(ApiRequest $request)
    {
        $siteId = null;
        $term = $request->input('term');
        $list = $request->input('list');

        if (!$request->has('multi-site') || !$request->get('multi-site', 0))
        {
            $siteId = $this->SiteDetector->current()->id;
        }
        $pages = $this->PagesRepository->searchPages($term, $siteId, $list, 20);
        return PageResource::collection($pages);
    }

    /**
     * Request a new page be created
     *
     * @param StorePage $request
     * @return PageResource
     */
    public function store(StorePage $request)
    {
        if ($request->input('site_id'))
        {
            $site = $this->SitesRepository->findById($request->input('site_id'));
        } else
        {
            $site = $this->SiteDetector->current();
        }

        $defaultLanguage = $site->default_language;

        $input = $request->all();

        $input['site_id'] = $site->id;
        $input['language_id'] = $request->input('language_id', $defaultLanguage->id);
        $input['meta_title'] = $input['title'];

        $page = $this->PagesManager->createNewPage($input);

        if ($request->get('publish_layout', false))
        {
            $this->Artisan->call('vendor:publish', [
                '--tag' => 'dvs-layouts', '--force' => 1
            ]);
        }

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