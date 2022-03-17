<?php

namespace Devise\Providers;

use Devise\Console\Commands\CleanStyledMedia;
use Devise\Console\Commands\GenerateSliceThumbnails;
use Devise\Devise;
use Devise\Models\DvsField;
use Devise\Models\DvsLanguage;
use Devise\Models\DvsPage;
use Devise\Models\DvsPageMeta;
use Devise\Models\DvsSite;
use Devise\Observers\DvsFieldObserver;
use Devise\Observers\ModelCacheFlushObserver;
use Devise\Sites\SiteDetector;
use Devise\Support\Database;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Compilers\BladeCompiler;

class DeviseServiceProvider extends ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(BladeCompiler $blade)
    {
        $this->setSnapshotConfig();

        $this->setSiteConfig();

        $this->setCommands();

        $this->setPublishables();

        $this->setRoutes();

        $this->loadLaravelResources();

        $this->setCustomDirectives();

        $this->setObservers();
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/devise.php', 'devise'
        );

        if (!class_exists('Devise'))
        {
            class_alias(Devise::class, 'Devise');
        }
    }

    private function setSnapshotConfig()
    {
        config()->set('filesystems.disks.snapshots.driver', 'local');
        config()->set('filesystems.disks.snapshots.root', database_path('snapshots'));
    }

    private function setSiteConfig()
    {
        if (!$this->app->runningInConsole() && Database::connected() && Schema::hasTable('dvs_sites'))
        {
            $siteDetector = App::make(SiteDetector::class);
            $site = $siteDetector->current();

            if ($site)
            {
                $protocol = request()->secure ? 'http://' : 'https://';
                config()->set('app.url', $protocol . $site->domain);
            }
        }
    }

    private function setCommands()
    {
        if ($this->app->runningInConsole())
        {
            $this->commands([
                CleanStyledMedia::class,
                GenerateSliceThumbnails::class,
            ]);
        }
    }

    private function setPublishables()
    {
        $this->publishes([
            __DIR__ . '/../../interface' => public_path('devise'),
        ], 'dvs-assets');

        $this->publishes([
            __DIR__ . '/../../config/devise.php' => config_path('devise.php'),
        ], 'dvs-config');

        $this->publishes([
            __DIR__ . '/../../resources/views/main-layout.blade.php' => resource_path('views/layouts/main.blade.php'),
        ], 'dvs-layouts');
    }

    private function setRoutes()
    {
        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');

        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
    }

    private function loadLaravelResources()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'devise');

        $this->loadTranslationsFrom(__DIR__ . '/../../lang', 'devise');
    }

    private function setCustomDirectives()
    {
        Blade::directive('slices', function ($expression) {
            return "<?php echo '<slices :slices=\"slices\" :parent-slice=\"devise.metadata.name\"></slices>' ?>";
        });
    }

    private function setObservers()
    {
        if (Database::connected())
        {
            DvsField::observe(DvsFieldObserver::class);
        }

        if (config('devise.cache_enabled'))
        {
            DvsPage::observe(ModelCacheFlushObserver::class);
            DvsLanguage::observe(ModelCacheFlushObserver::class);
            DvsPageMeta::observe(ModelCacheFlushObserver::class);
            DvsSite::observe(ModelCacheFlushObserver::class);
        }
    }
}