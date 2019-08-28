<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;
use Devise\Http\Resources\Api\LanguageResource;
use Devise\Models\DvsLanguage;

use Illuminate\Routing\Controller;

class SitesLanguagesController extends Controller
{
    /**
     * @var DvsLanguage
     */
    private $DvsLanguage;


    /**
     * SitesController constructor.
     * @param DvsLanguage $DvsLanguage
     */
    public function __construct(DvsLanguage $DvsLanguage)
    {
        $this->DvsLanguage = $DvsLanguage;
    }

    public function index(ApiRequest $request, $siteId)
    {
        $all = $this->DvsLanguage
            ->join('dvs_site_language', 'dvs_site_language.language_id', '=', 'dvs_languages.id')
            ->where('dvs_site_language.site_id', $siteId)
            ->select('dvs_languages.*')
            ->get();

        return LanguageResource::collection($all);
    }
}