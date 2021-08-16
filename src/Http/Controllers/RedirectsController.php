<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;
use Devise\Http\Requests\Redirects\ExecuteRedirect;
use Devise\Http\Requests\Redirects\SaveRedirect;
use Devise\Http\Requests\Redirects\DeleteRedirect;
use Devise\Http\Resources\Api\RedirectResource;
use Devise\Models\DvsRedirect;

use Devise\Sites\SiteDetector;
use Devise\Support\Framework;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;

class RedirectsController extends Controller
{
    private $DvsRedirect;

    private $SiteDetector;

    private $Route;

    /**
     * RedirectsController constructor.
     * @param DvsRedirect $DvsRedirect
     */
    public function __construct(DvsRedirect $DvsRedirect, SiteDetector $SiteDetector, Framework $Framework)
    {
        $this->DvsRedirect = $DvsRedirect;
        $this->SiteDetector = $SiteDetector;
        $this->Route = $Framework->Route;
    }

    /**
     * @param ApiRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function all(ApiRequest $request)
    {
        $site = $this->SiteDetector
            ->current();

        $all = $this->DvsRedirect
            ->where('site_id', $site->id)
            ->get();

        return RedirectResource::collection($all);
    }

    /**
     * @param ApiRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(ExecuteRedirect $request)
    {
        $name = $this->Route->currentRouteName();
        $parts = explode('-', $name);
        $id = last($parts);

        $redirect = $this->DvsRedirect
            ->findOrFail($id);

        return redirect($redirect->newUrl($request), $redirect->type);
    }

    /**
     * @param SaveRedirect $request
     * @return RedirectResource
     */
    public function store(SaveRedirect $request)
    {
        $site = $this->SiteDetector
            ->current();

        $redirect = new DvsRedirect();
        $redirect->fill($request->only($redirect->fillable));
        $redirect->site_id = $site->id;
        $redirect->save();

        $this->refreshRouteCache();

        return new RedirectResource($redirect);
    }

    /**
     * @param SaveRedirect $request
     * @param $id
     * @return RedirectResource
     */
    public function update(SaveRedirect $request, $id)
    {
        $redirect = $this->DvsRedirect
            ->findOrFail($id);

        $redirect->fill($request->only($redirect->fillable));
        $redirect->save();

        $this->refreshRouteCache();

        return new RedirectResource($redirect);
    }

    /**
     * @param DeleteRedirect $request
     * @param $id
     */
    public function delete(DeleteRedirect $request, $id)
    {
        $redirect = $this->DvsRedirect
            ->findOrFail($id);

        $redirect->delete();

        $this->refreshRouteCache();
    }

    private function refreshRouteCache()
    {
        if (App::routesAreCached()) {
            Artisan::call('route:cache');
        }
    }
}