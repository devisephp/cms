<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;
use Devise\Http\Requests\Slices\SaveSlice;
use Devise\Http\Requests\Slices\DeleteSlice;
use Devise\Http\Resources\Api\SliceResource;
use Devise\Models\DvsSlice;

use Illuminate\Routing\Controller;

class SlicesController extends Controller
{
  /**
   * @var DvsSlice
   */
  private $DvsSlice;


  /**
   * SlicesController constructor.
   * @param DvsSlice $DvsSlice
   */
  public function __construct(DvsSlice $DvsSlice)
  {
    $this->DvsSlice = $DvsSlice;
  }

  public function all(ApiRequest $request)
  {
    $all = $this->DvsSlice
      ->get();

    return SliceResource::collection($all);
  }

  /**
   * @param SaveSlice $request
   * @return SliceResource
   */
  public function store(SaveSlice $request)
  {
    $new = $this->DvsSlice
      ->createFromRequest($request);

    return new SliceResource($new);
  }

  /**
   * @param SaveSlice $request
   * @param $id
   * @return SliceResource
   */
  public function update(SaveSlice $request, $id)
  {
    $template = $this->DvsSlice
      ->findOrFail($id);

    $template->updateFromRequest($request);

    return new SliceResource($template);
  }

  /**
   * @param DeleteSlice $request
   * @param $id
   */
  public function delete(DeleteSlice $request, $id)
  {
    $template = $this->DvsSlice
      ->findOrFail($id);

    if($template->pageVersions->count()) abort(422, 'Slice must be removed from all pages before deleting.');

    $template->delete();
  }
}