<?php

namespace Devise\Providers;

use Devise\Console\Commands\CleanStyledMedia;
use Devise\Console\Commands\Install;
use Devise\Devise;

use Devise\Models\DvsField;
use Devise\Observers\DvsFieldObserver;
use Devise\Sites\SiteDetector;
use Illuminate\Support\Facades\App;
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
        if (!$this->app->runningInConsole())
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
                Install::class,
            ]);

            $this->commands([
                CleanStyledMedia::class,
            ]);
        }
    }

    private function setPublishables()
    {
        $this->publishes([
            __DIR__ . '/../../vue/build' => public_path('devise'),
        ], 'dvs-assets');

        $this->publishes([
            __DIR__ . '/../../config/devise.php' => config_path('devise.php'),
        ], 'dvs-config');
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
            return "<?php echo '<slices :slices=\"slices\"/>' ?>";
        });
    }

    private function setObservers()
    {
        DvsField::observe(DvsFieldObserver::class);
    }
}
