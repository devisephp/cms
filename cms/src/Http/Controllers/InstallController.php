<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;

use Devise\Support\Database;
use Devise\Support\Env;
use Devise\Traits\HasPermissions;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Spatie\ImageOptimizer\OptimizerChain;

class InstallController extends Controller
{
    /**
     * @var OptimizerChain
     */
    private $OptimizerChain;


    /**
     * InstallController constructor.
     */
    public function __construct(OptimizerChain $OptimizerChain)
    {
        $this->OptimizerChain = $OptimizerChain;
    }

    public function checklist(ApiRequest $request)
    {
        return [
            "database"           => Database::connected(),
            "migrations"         => $this->migrationsAreRun(),
            "auth"               => $this->basicAuthIsReady(),
            "user"               => $this->firstUserReady(),
            "site"               => $this->firstSiteReady(),
            "page"               => $this->firstPageReady(),
            "slices"             => $this->slicesFolderRead(),
            "image_library"      => $this->imageLibraryAvailable(),
            "image_optimization" => $this->optimizersStatus()
        ];
    }

    public function complete(ApiRequest $request)
    {
        Env::set('DVS_MODE', 'active');
    }

    private function migrationsAreRun()
    {
        return (
            Database::connected()
            &&
            Schema::hasTable('migrations')
            &&
            Schema::hasTable('dvs_pages')
        );
    }

    private function basicAuthIsReady()
    {
        return (
            Database::connected()
            &&
            Schema::hasTable('users')
            &&
            Route::has('login')
        );
    }

    private function firstUserReady()
    {
        $webGuardProvider = config('auth.guards.web.provider');
        $userModel = config("auth.providers.$webGuardProvider.model");

        return (
            Database::connected()
            &&
            Schema::hasTable('users')
            &&
            DB::table('users')->count() > 0
            &&
            in_array(HasPermissions::class, class_uses($userModel))
        );
    }

    private function firstSiteReady()
    {
        return (
            Database::connected()
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
            Database::connected()
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

    private function imageLibraryAvailable()
    {
        return (extension_loaded('gd') || extension_loaded('imagick'));
    }

    private function optimizersStatus()
    {
        $status = [];
        $optimizers = $this->OptimizerChain->getOptimizers();
        dd($optimizers);
        foreach ($optimizers as $optimizer)
        {
            $status[$optimizer->binaryName] = $optimizer->binaryPath !== "";
        }

        return $status;
    }

    private function slicesFolderRead()
    {
        return File::isDirectory(resource_path('views/slices'));
    }
}