<?php

namespace Devise\Http\Controllers;

use Devise\Http\Requests\ApiRequest;

use Illuminate\Database\Query\Builder;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
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
            "database"           => Builder::connected(),
            "migrations"         => $this->migrationsAreRun(),
            "auth"               => $this->basicAuthIsReady(),
            "user"               => $this->firstUserReady(),
            "site"               => $this->firstSiteReady(),
            "page"               => $this->firstPageReady(),
            "image_library"      => $this->imageLibraryAvailable(),
            "image_optimization" => $this->optimizersStatus()
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

    private function imageLibraryAvailable()
    {
        return (extension_loaded('gd') || extension_loaded('imagick'));
    }

    private function optimizersStatus()
    {
        $status = [];
        $optimizers = $this->OptimizerChain->getOptimizers();
        foreach ($optimizers as $optimizer){
            $status[ $optimizer->binaryName ] = $optimizer->binaryPath !== "";
        }
        return $status;
    }
}