<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;
use Devise\Http\Requests\Redirects\SaveRedirect;
use Devise\Http\Requests\Redirects\DeleteRedirect;
use Devise\Http\Resources\Api\RedirectResource;
use Devise\Models\DvsRedirect;

use Illuminate\Routing\Controller;

class RedirectsController extends Controller
{
  /**
   * @var DvsRedirect
   */
  private $DvsRedirect;

  /**
   * RedirectsController constructor.
   * @param DvsRedirect $DvsRedirect
   */
  public function __construct(DvsRedirect $DvsRedirect)
  {
    $this->DvsRedirect = $DvsRedirect;
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
    $new = $this->DvsRedirect
      ->createFromRequest($request);

    return new RedirectResource($new);
  }

  /**
   * @param SaveRedirect $request
   * @param $id
   * @return RedirectResource
   */
  public function update(SaveRedirect $request, $id)
  {
    $slice = $this->DvsRedirect
      ->findOrFail($id);

    $slice->updateFromRequest($request);

    return new RedirectResource($slice);
  }

  /**
   * @param DeleteRedirect $request
   * @param $id
   */
  public function delete(DeleteRedirect $request, $id)
  {
    $slice = $this->DvsRedirect
      ->findOrFail($id);

    $slice->delete();
  }
}