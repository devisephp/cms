<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;
use Devise\Http\Requests\Languages\SaveLanguage;
use Devise\Http\Requests\Languages\DeleteLanguage;
use Devise\Http\Resources\Api\LanguageResource;
use Devise\Models\DvsLanguage;

use Illuminate\Routing\Controller;

class LanguagesController extends Controller
{
  /**
   * @var DvsLanguage
   */
  private $DvsLanguage;


  /**
   * LanguagesController constructor.
   * @param DvsLanguage $DvsLanguage
   */
  public function __construct(DvsLanguage $DvsLanguage)
  {
    $this->DvsLanguage = $DvsLanguage;
  }

  public function all(ApiRequest $request)
  {
    $all = $this->DvsLanguage
      ->get();

    return LanguageResource::collection($all);
  }

  /**
   * @param SaveLanguage $request
   * @return LanguageResource
   */
  public function store(SaveLanguage $request)
  {
    $new = $this->DvsLanguage
      ->createFromRequest($request);

    return new LanguageResource($new);
  }

  /**
   * @param SaveLanguage $request
   * @param $id
   * @return LanguageResource
   */
  public function update(SaveLanguage $request, $id)
  {
    $language = $this->DvsLanguage
      ->findOrFail($id);

    $language->updateFromRequest($request);

    return new LanguageResource($language);
  }
}