<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;
use Devise\Http\Requests\Redirects\SaveRedirect;
use Devise\Http\Requests\Redirects\DeleteRedirect;
use Devise\Http\Resources\Api\RedirectResource;
use Devise\Models\DvsRedirect;

use Devise\Sites\SiteDetector;
use Illuminate\Routing\Controller;

class RedirectsController extends Controller
{
    /**
     * @var DvsRedirect
     */
    private $DvsRedirect;
    /**
     * @var SiteDetector
     */
    private $SiteDetector;

    /**
     * RedirectsController constructor.
     * @param DvsRedirect $DvsRedirect
     */
    public function __construct(DvsRedirect $DvsRedirect, SiteDetector $SiteDetector)
    {
        $this->DvsRedirect = $DvsRedirect;
        $this->SiteDetector = $SiteDetector;
    }

    /**
     * @param ApiRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function all(ApiRequest $request)
    {
        $all = $this->DvsRedirect
            ->get();

        return RedirectResource::collection($all);
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
    }
}