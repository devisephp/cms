<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;
use Devise\Pages\PagesRepository;

use Devise\Sites\SiteDetector;
use Illuminate\Support\Facades\Route;

class SeoController
{
    /**
     * @var SiteDetector
     */
    private $SiteDetector;
    /**
     * @var PagesRepository
     */
    private $PagesRepository;

    public function __construct(SiteDetector $SiteDetector, PagesRepository $PagesRepository)
    {
        $this->SiteDetector = $SiteDetector;
        $this->PagesRepository = $PagesRepository;
    }

    public function sitemap()
    {
        $pages = $this->PagesRepository
            ->getPublishedPages();

        return response()
            ->view('devise::seo.sitemap-xml', ['pages' => $pages], 200)
            ->withHeaders([
                'Content-Type' => 'text/xml'
            ]);
    }

    public function sitemapJson(ApiRequest $request)
    {
        $site = $this->SiteDetector
            ->current();

        $currentDomain = $request->getHost();

        $prefix = ($site->domain == $currentDomain) ? '' : $currentDomain;
        
        $pages = $this->PagesRepository
            ->getPublishedPages();

        return $pages->map(function ($page, $key) use ($prefix) {
            if (Route::getRoutes()->hasNamedRoute($prefix . $page->route_name))
            {
                return route($prefix . $page->route_name);
            }
        });
    }
}