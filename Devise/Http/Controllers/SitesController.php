<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;
use Devise\Http\Requests\Sites\SaveSite;
use Devise\Http\Requests\Sites\DeleteSite;
use Devise\Http\Resources\Api\SiteResource;
use Devise\Models\DvsSite;

use Illuminate\Routing\Controller;

class SitesController extends Controller
{
    /**
     * @var DvsSite
     */
    private $DvsSite;


    /**
     * SitesController constructor.
     * @param DvsSite $DvsSite
     */
    public function __construct(DvsSite $DvsSite)
    {
        $this->DvsSite = $DvsSite;
    }

    public function all(ApiRequest $request)
    {
        $all = $this->DvsSite
            ->with('languages')
            ->get();

        return SiteResource::collection($all);
    }

    /**
     * @param SaveSite $request
     * @return SiteResource
     */
    public function store(SaveSite $request)
    {
        $new = $this->DvsSite
            ->createFromRequest($request);

        if ($request->get('devdomain', false))
        {
            $this->setEnvironmentValue('DVS_DOMAIN_OVERWRITES_ENABLED', 'true');
            $this->setEnvironmentValue('SITE_1_DOMAIN', $request->get('devdomain'));
        }

        $syncdata = $this->getLanguageSyncData($request->input('languages', []));

        $new->languages()->sync($syncdata);

        $new->load('languages');

        return new SiteResource($new);
    }

    /**
     * @param SaveSite $request
     * @param $id
     * @return SiteResource
     */
    public function update(SaveSite $request, $id)
    {
        $site = $this->DvsSite
            ->findOrFail($id);

        $site->updateFromRequest($request);

        $syncdata = $this->getLanguageSyncData($request->input('languages', []));

        $site->languages()->sync($syncdata);

        $site->load('languages');

        return new SiteResource($site);
    }

    /**
     * @param DeleteSite $request
     * @param $id
     */
    public function delete(DeleteSite $request, $id)
    {
        $site = $this->DvsSite
            ->findOrFail($id);

        $site->delete();
    }

    private function getLanguageSyncData($languages)
    {
        $languages = collect($languages);
        $languages = $languages->keyBy('id');

        return $languages->map(function ($language) {
            return ['default' => $language['default']];
        });
    }

    private function setEnvironmentValue($envKey, $envValue)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        $oldValue = env($envKey);

        if ($oldValue)
        {
            $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}\n", $str);
        } else
        {
            $str .= "\n{$envKey}={$envValue}";
        }

        $fp = fopen($envFile, 'w');
        fwrite($fp, $str);
        fclose($fp);
    }
}