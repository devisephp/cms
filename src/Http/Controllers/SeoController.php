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
        $pages = $this->PagesRepository
            ->getPublishedPages();

        return $pages->map(function ($page, $key) {
            if (Route::getRoutes()->hasNamedRoute($page->route_name))
            {
                return route($page->route_name);
            }
        });
    }
}