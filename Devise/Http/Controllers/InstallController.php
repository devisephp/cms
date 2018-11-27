<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;

use Illuminate\Database\Query\Builder;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;

class InstallController extends Controller
{

    public function checklist(ApiRequest $request)
    {
        return [
            "database"           => Builder::connected(),
            "migrations"         => $this->migrationsAreRun(),
            "auth"               => $this->basicAuthIsReady(),
            "user"               => $this->firstUserReady(),
            "site"               => $this->firstSiteReady(),
            "page"               => $this->firstPageReady(),
            "image_library"      => true,
            "image_optimization" => [
                "jpegoptim" => true,
                "optipng  " => false,
                "pngquant"  => true,
                "svgo"      => true,
                "gifsicle"  => true
            ]
        ];
    }

    private function migrationsAreRun()
    {
        return (
            Builder::connected()
            &&
            Schema::hasTable('migrations')
            &&
            Schema::hasTable('dvs_pages')
        );
    }

    private function basicAuthIsReady()
    {
        return (
            Builder::connected()
            &&
            Schema::hasTable('users')
            &&
            Route::has('login')
        );
    }

    private function firstUserReady()
    {
        return (
            Builder::connected()
            &&
            Schema::hasTable('users')
            &&
            DB::table('users')->count() > 0
        );
    }

    private function firstSiteReady()
    {
        return (
            Builder::connected()
            &&
            Schema::hasTable('dvs_sites')
            &&
            DB::table('dvs_sites')->count() > 0
            &&
            Schema::hasTable('dvs_languages')
            &&
            DB::table('dvs_languages')->count() > 0
            &&
            Schema::hasTable('dvs_site_language')
            &&
            DB::table('dvs_site_language')->where('default', 1)->count() > 0
        );
    }

    private function firstPageReady()
    {
        return (
            Builder::connected()
            &&
            Schema::hasTable('dvs_pages')
            &&
            DB::table('dvs_pages')->count() > 0
            &&
            Schema::hasTable('dvs_page_versions')
            &&
            DB::table('dvs_page_versions')->count() > 0
        );
    }
}